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
use Symfony\Component\DependencyInjection\Definition;
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

    if (isset($_config['templating']['entity']))
    {
      $definition = $container->getDefinition('aw_email_templating.template.loader.doctrine');
      $definition->replaceArgument(1, $_config['templating']['entity']);
    }

    $loaderDefinition = $container->getDefinition($_config['templating']['loader']);

    $definition = $container->getDefinition('aw_email_templating.template.factory');
    $definition->replaceArgument(0, $loaderDefinition);

    if (isset($_config['templating']['images_as_attachment']) && $_config['templating']['images_as_attachment'])
    {
      $listener = $container->getDefinition('aw_email_templating.listener.image_as_attachment');
//      $imagesAsAttachment = new Definition('Accurateweb\\EmailTemplateBundle\\EventListener', array(
//        $container->getParameter('kernel.root_dir').'/../web/'
//      ));
      $listener->addTag('kernel.event_listener', array(
        'name' => 'kernel.event_listener',
        'event' => 'aw.email.message.create',
        'method' => 'onCreateMessage',
      ));
//      $container->get('event_dispatcher')->addListenerService('aw.email.message.create', array($listener, 'onCreateMessage'));
    }
  }

  public function getAlias()
  {
    return 'aw_email_templating';
  }
}