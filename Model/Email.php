<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Model;


class Email implements EmailInterface
{
  private $recipients;

  private $subject;

  private $body;

  public function __construct($subject, $body, array $recipients=array())
  {
    $this->subject = $subject;
    $this->body = $body;
    $this->recipients = $recipients;
  }

  public function getRecipients()
  {
    return $this->recipient;
  }

  /**
   * @return mixed
   */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
   * @return mixed
   */
  public function getBody()
  {
    return $this->body;
  }


}