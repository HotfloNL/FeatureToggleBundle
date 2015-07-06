<?php

namespace Hotflo\FeatureToggleBundle\Tests\DependencyInjection;

use Hotflo\FeatureToggleBundle\DependencyInjection\HotfloFeatureToggleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HotfloFeatureToggleExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HotfloFeatureToggleExtension
     */
    private $extension;

    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        $this->extension = new HotfloFeatureToggleExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    public function testLoad()
    {
        $config = [
            [
                'toggles' => [
                    'generic' => ['type' => 'service', 'service' => 'hotflo_feature_toggle.generic_feature_toggle']
                ],
                'features' => [
                    'my_feature' => ['toggle' => 'generic', 'options' => ['key' => 'value']],
                    'my_second_feature' => ['toggle' => 'generic']
                ]
            ]
        ];

        $this->extension->load($config, $this->container);

        $this->assertTrue($this->container->hasDefinition('hotflo_feature_toggle.feature.my_feature'));
        $this->assertTrue($this->container->hasDefinition('hotflo_feature_toggle.feature.my_second_feature'));
    }
}
