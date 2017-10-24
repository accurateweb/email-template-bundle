<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AccuratewebEmailTemplateExtension extends Extension
{
  public function load(array $config, ContainerBuilder $container)
  {
    $configuration = new Configuration();
    $_config = $this->processConfiguration($configuration, $config);

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

    $loader->load('email_templates.yml');
    $loader->load('services.yml');

    $definition = $container->getDefinition('aw_email_templating.template.factory');
    foreach ($_config['email_templates'] as $name => $configuration)
    {
      $definition->addMethodCall('setTemplate', array($name, $configuration));
    }
  }

  public function getAlias()
  {
    return 'aw_email_templating';
  }
}