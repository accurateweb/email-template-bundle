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


interface EmailTemplateInterface
{
  public function getId();

  public function getDescription();

  public function getSupportedVariables();

  /**
   * Returns Email subject template
   *
   * @return string
   */
  public function getSubject();

  /**
   * Set Email subject template
   *
   * @param string $subject Email subject template
   */
  public function setSubject($subject);

  /**
   * Returns Email body template
   *
   * @return string Email body template
   */
  public function getBody();

  /**
   * Set Email body template
   *
   * @param string $body Email body template
   */
  public function setBody($body);


}