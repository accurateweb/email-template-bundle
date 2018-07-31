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


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();

    $rootNode = $treeBuilder->root('aw_email_templating');

    $rootNode
      ->children()
        ->arrayNode('templating')
          ->children()
            ->scalarNode('loader')->defaultValue('aw_email_templating.template.loader.default')->end()
            ->booleanNode('images_as_attachment')->defaultFalse()->end()
            ->scalarNode('entity')->end()
          ->end()
        ->end()
        ->arrayNode('email_templates')
          ->prototype('array')
            ->children()
              ->scalarNode('alias')->end()
              ->scalarNode('description')->end()
              ->arrayNode('variables')
                ->prototype('array')
                  ->children()
                    ->scalarNode('description')->end()
                  ->end()
                ->end()
              ->end()
              ->arrayNode('defaults')
                ->children()
                  ->scalarNode('subject')->end()
                  ->scalarNode('body')->end()
                ->end()
              ->end()
            ->end()
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }

}