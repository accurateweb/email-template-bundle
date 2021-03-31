<?php

namespace Accurateweb\EmailTemplateBundle\EventListener;

use Accurateweb\EmailTemplateBundle\Event\EmailMessageEvent;
use Swift_IoException;
use Psr\Log\LoggerInterface;

class ImagesAsAttachment
{
  private $imageBaseDir;
  private $logger;
  private $replace;

  public function __construct ($imageBaseDir, LoggerInterface $logger, $replace = false)
  {
    $this->imageBaseDir = $imageBaseDir;
    $this->logger = $logger;
    $this->replace = $replace;
  }

  public function onCreateMessage (EmailMessageEvent $emailMessageEvent)
  {
    if (!$this->replace)
    {
      return false;
    }

    $message = $emailMessageEvent->getMessage();
    $body = $message->getBody();
    preg_match_all('~<img.*?src=.([\/.a-z0-9:_-]+).*?>~si', $body, $matches);

    foreach ($matches[1] as $img)
    {
      if (preg_match('#^[a-zA-Z]+://#', $img))
      {
        $ext = preg_replace('/.*\.(.+)$/', '$1', $img);
        $filePath = tempnam(sys_get_temp_dir(), 'AwEmailImage') . '.' . $ext;

        try
        {
          $imgContent = file_get_contents($img);
        }
        catch (\Exception $e)
        {
          /*
           * Если попытка скачать изображение вызвала исключение (например не можем разресолвить домен или изображение отсутствует),
           *   то не будем заменять ее
           * Есть вариант вставлять в таких случаях заглушку
           */
          continue;
        }

        if ($imgContent === false)
        {
          continue;
        }

        file_put_contents($filePath, $imgContent);
      }
      else
      {
        if (preg_match('/^\.\.\/.*/', $img))
        {
          $img = '/'.$img;
        }

        $filePath = sprintf('%s%s', $this->imageBaseDir, $img);
      }

      if (file_exists($filePath))
      {
        try
        {
          $cid = $message->embed(\Swift_Image::fromPath($filePath));
        }
        catch (Swift_IoException $e)
        {
          $this->logger->warning($e->getMessage());
        }

        $body = str_replace($img, $cid, $body);
      }
    }

    $message->setBody($body);
  }
}