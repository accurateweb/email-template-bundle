<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Accurateweb\EmailTemplateBundle\Template\Loader;

use Accurateweb\EmailTemplateBundle\Template\EmailTemplateInterface;

/**
 * Interface TemplateLoaderInterface
 *
 * @package Accurateweb\EmailTemplateBundle\Template\Loader
 */
interface TemplateLoaderInterface
{
  /**
   * Loads actual template text values from template source
   *
   * @param EmailTemplateInterface $template
   */
  public function load(EmailTemplateInterface $template);
}