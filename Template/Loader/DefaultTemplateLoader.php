<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Template\Loader;


use Accurateweb\EmailTemplateBundle\Template\EmailTemplateInterface;

class DefaultTemplateLoader implements TemplateLoaderInterface
{
  /**
   * @param EmailTemplateInterface $template
   */
  public function load(EmailTemplateInterface $template)
  {
    //This preserves the default values, so nothing to do.
  }
}