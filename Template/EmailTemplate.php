<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Template;

class EmailTemplate implements EmailTemplateInterface
{
  private $alias,
          $variables,
          $body,
          $description = null;

  function __construct($alias, $description, $subject, $body, $variables = array())
  {
    $this->alias = $alias;
    $this->description = $description;
    $this->subject = $subject;
    $this->body = $body;
    $this->variables = $variables;
  }

  public function getAlias()
  {
    return $this->alias;
  }

  public function getBody()
  {
    return $this->body;
  }

  public function setBody($v)
  {
    $this->body = $v;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getValue($variable, $values, $defaultValue=null)
  {
    return isset($values[$variable]) ? $values[$variable] : $defaultValue;
  }

  public function getVariables()
  {
    return $this->variables;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function getSupportedVariables()
  {
    return $this->getVariables();
  }

  /**
   * Returns Email subject template
   *
   * @return string
   */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
   * Set Email subject template
   *
   * @param string $subject Email subject template
   */
  public function setSubject($subject)
  {
    $this->subject = $subject;
  }


}