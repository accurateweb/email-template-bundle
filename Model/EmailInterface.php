<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Accurateweb\EmailTemplateBundle\Model;

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

interface EmailInterface
{
  public function getRecipients();

  public function getSubject();

  public function getBody();
}