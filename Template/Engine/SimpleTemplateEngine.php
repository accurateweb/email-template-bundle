<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */
namespace Accurateweb\EmailTemplateBundle\Template\Engine;

class SimpleTemplateEngine implements TemplateEngineInterface
{
  public function render($template, $values)
  {
    $replacements = array();
    foreach ($values as $variable => $value)
    {
      $replacements['%'.$variable.'%'] = $value;
    }

    return strtr($template, $replacements);
  }
}