<?php

namespace Accurateweb\EmailTemplateBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImagesAsAttachmentCompilerPass implements CompilerPassInterface
{
  public function process (ContainerBuilder $container)
  {
    $config = $container->getExtensionConfig('aw_email_templating');
    $_config = $config[0];

    $needReplaceImage = isset($_config['templating']['images_as_attachment']) && $_config['templating']['images_as_attachment'];

    $listener = $container->getDefinition('aw_email_templating.listener.image_as_attachment');
    $listener->replaceArgument(2, $needReplaceImage);
  }
}