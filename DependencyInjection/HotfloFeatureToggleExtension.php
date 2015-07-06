<?php

namespace Hotflo\FeatureToggleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HotfloFeatureToggleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->handleConfiguration($config, $container);
    }

    protected function handleConfiguration($config, ContainerBuilder $container)
    {
        if (!isset($config['features'])) {
            return;
        }

        if (!$container->hasDefinition('hotflo_feature_toggle.feature_container')) {
            return;
        }

        $featureToggleContainerDefinition = $container->findDefinition('hotflo_feature_toggle.feature_toggle_container');

        foreach ($config['toggles'] as $toggle => $properties) {
            if ($properties['type'] == 'service') {
                if (!$container->hasDefinition($properties['service'])) {
                    throw new InvalidConfigurationException(
                        sprintf('Service \'%s\' not found in service container.', $properties['service'])
                    );
                }

                $container->setDefinition('hotflo_feature_toggle.toggle.' . $toggle, $container->findDefinition($properties['service']));
            } else {
                if (!class_exists($properties['class'])) {
                    throw new InvalidConfigurationException(
                        sprintf('Class \'%s\' not found.', $properties['class'])
                    );
                }

                $toggleDefinition = new Definition($properties['class']);
                $toggleDefinition->addArgument($properties['options']);
                $container->setDefinition('hotflo_feature_toggle.toggle.' . $toggle, $toggleDefinition);
            }

            $featureToggleContainerDefinition->addMethodCall(
                'addFeatureToggle',
                [new Reference('hotflo_feature_toggle.toggle.' . $toggle), $toggle]
            );
        }

        $featureContainerDefinition = $container->findDefinition('hotflo_feature_toggle.feature_container');

        foreach ($config['features'] as $feature => $properties) {
            $featureDefinition = new Definition('JoshuaEstes\Component\FeatureToggle\Feature');
            $featureDefinition->addArgument($properties['options']);
            $featureDefinition->addMethodCall('setKey', [$feature]);
            $featureDefinition->addMethodCall('setToggle', [new Reference('hotflo_feature_toggle.toggle.' . $properties['toggle'])]);
            $container->setDefinition('hotflo_feature_toggle.feature.' . $feature, $featureDefinition);

            $featureContainerDefinition->addMethodCall('addFeature', [new Reference('hotflo_feature_toggle.feature.' . $feature)]);
        }
    }
}
