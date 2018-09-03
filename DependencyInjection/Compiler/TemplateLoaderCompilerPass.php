<?php

namespace Accurateweb\EmailTemplateBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class TemplateLoaderCompilerPass implements CompilerPassInterface
{
  public function process (ContainerBuilder $container)
  {
    $config = $container->getExtensionConfig('aw_email_templating');
    $_config = $config[0];

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../Resources/config'));

    $loader->load('email_templates.yml');
    $loader->load('services.yml');

    $definition = $container->getDefinition('aw_email_templating.template.factory');

    foreach ($_config['email_templates'] as $name => $configuration)
    {
      $definition->addMethodCall('setTemplate', array($name, $configuration));
    }

    if (isset($_config['templating']['entity']))
    {
      $definition = $container->getDefinition('aw_email_templating.template.loader.doctrine');
      $definition->replaceArgument(1, $_config['templating']['entity']);
    }

    $loaderDefinition = $container->getDefinition($_config['templating']['loader']);

    $definition = $container->getDefinition('aw_email_templating.template.factory');
    $definition->replaceArgument(0, $loaderDefinition);
  }

}