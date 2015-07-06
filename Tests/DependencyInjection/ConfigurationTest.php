<?php

namespace Hotflo\FeatureToggleBundle\Tests\DependencyInjection;

use Hotflo\FeatureToggleBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * Return the instance of ConfigurationInterface that should be used by the
     * Configuration-specific assertions in this test-case
     *
     * @return \Symfony\Component\Config\Definition\ConfigurationInterface
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testValuesAreInvalidIfRequiredValueIsNotProvided()
    {
        $this->assertConfigurationIsInvalid([[]]);
    }

    public function testProcessedValueContainsRequiredValue()
    {
        $this->assertProcessedConfigurationEquals([
            [
                'toggles' => [
                    'generic' => ['type' => 'service', 'service' => 'hotflo_feature_toggle.generic_feature_toggle']
                ],
                'features' => [
                    'my_feature' => ['toggle' => 'generic', 'options' => ['key' => 'value']],
                    'my_second_feature' => ['toggle' => 'generic']
                ]
            ]
        ], [
            'toggles' => [
                'generic' => ['type' => 'service', 'service' => 'hotflo_feature_toggle.generic_feature_toggle', 'options' => []]
            ],
            'features' => [
                'my_feature' => ['toggle' => 'generic', 'options' => ['key' => 'value']],
                'my_second_feature' => ['toggle' => 'generic', 'options' => []]
            ]
        ]);
    }
}
