<?php

namespace Accurateweb\EmailTemplateBundle\EventListener;

use Accurateweb\EmailTemplateBundle\Event\EmailMessageEvent;

class ImagesAsAttachment
{
  private $imageBaseDir;

  public function __construct ($imageBaseDir)
  {
    $this->imageBaseDir = $imageBaseDir;
  }

  public function onCreateMessage (EmailMessageEvent $emailMessageEvent)
  {
    $message = $emailMessageEvent->getMessage();
    $body = $message->getBody();
    preg_match_all('~<img.*?src=.([\/.a-z0-9:_-]+).*?>~si', $body, $matches);

    foreach ($matches[1] as $img)
    {
      if (preg_match('#^[a-zA-Z]+://#', $img))
      {
        $filePath = tempnam(sys_get_temp_dir(), 'AwEmailImage');

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

        file_put_contents($filePath, $imgContent);
      }
      else
      {
        $filePath = sprintf('%s%s', $this->imageBaseDir, $img);
      }

      $cid = $message->embed(\Swift_Image::fromPath($filePath));
      $body = str_replace($img, $cid, $body);
    }

    $message->setBody($body);
  }
}