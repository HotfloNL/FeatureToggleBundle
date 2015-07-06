<?php

namespace Hotflo\FeatureToggleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hotflo_feature_toggle');

        $rootNode
            ->children()
                ->arrayNode('toggles')
                    ->isRequired()
                    ->useAttributeAsKey('toggle')
                    ->prototype('array')
                        ->children()
                            ->enumNode('type')->defaultValue('class')->values(array('class', 'service'))->end()
                            ->scalarNode('class')->end()
                            ->scalarNode('service')->end()
                            ->arrayNode('options')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('features')
                    ->isRequired()
                    ->useAttributeAsKey('feature')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('toggle')->isRequired()->end()
                            ->arrayNode('options')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
