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

      if (!preg_match('#^[a-zA-Z]+://#', $img))
      {
        $cid = $message->embed(\Swift_Image::fromPath($this->imageBaseDir . $img));
        $body = str_replace($img, $cid, $body);
      }
    }

    $message->setBody($body);
  }
}