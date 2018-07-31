<?php

namespace Accurateweb\EmailTemplateBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EmailMessageEvent extends Event
{
  private $message;

  public function __construct (\Swift_Message $message)
  {
    $this->message = $message;
  }

  /**
   * @return \Swift_Message
   */
  public function getMessage ()
  {
    return $this->message;
  }
}