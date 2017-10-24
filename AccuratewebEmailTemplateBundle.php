<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle;

use Accurateweb\EmailTemplateBundle\DependencyInjection\AccuratewebEmailTemplateExtension;
use Accurateweb\EmailTemplateBundle\DependencyInjection\Compiler\TwigFormResourceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AccuratewebEmailTemplateBundle extends Bundle
{
  public function getContainerExtension()
  {
    if (null === $this->extension)
    {
      $this->extension = new AccuratewebEmailTemplateExtension();
    }

    return $this->extension;
  }

  public function build(ContainerBuilder $container)
  {
    $container->addCompilerPass(new TwigFormResourceCompilerPass());
  }
}