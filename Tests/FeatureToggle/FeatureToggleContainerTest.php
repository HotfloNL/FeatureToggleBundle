<?php

namespace Hotflo\FeatureToggleBundle\Tests\FeatureToggle;

use Hotflo\FeatureToggleBundle\FeatureToggle\FeatureToggleContainer;
use JoshuaEstes\Component\FeatureToggle\Toggle\FeatureToggleGeneric;

class FeatureToggleContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FeatureToggleContainer
     */
    private $container;

    protected function setUp()
    {
        parent::setUp();

        $this->container = new FeatureToggleContainer();
    }

    public function testAddFeatureToggle()
    {
        $this->container->addFeatureToggle($featureToggle = new FeatureToggleGeneric(), 'generic');

        $this->assertTrue(in_array('generic', $this->container->availableFeatureToggles()));
        $this->assertEquals($featureToggle, $this->container->getFeatureToggle('generic'));
    }

    public function testRemoveFeatureToggle()
    {
        $this->container->addFeatureToggle($featureToggle = new FeatureToggleGeneric(), 'generic');

        $this->assertTrue(in_array('generic', $this->container->availableFeatureToggles()));

        $this->container->removeFeatureToggle('generic');

        $this->assertFalse(in_array('generic', $this->container->availableFeatureToggles()));
    }

    public function testHasFeatureToggle()
    {
        $this->container->addFeatureToggle($featureToggle = new FeatureToggleGeneric(), 'generic');

        $this->assertTrue($this->container->hasFeatureToggle('generic'));
    }
}
