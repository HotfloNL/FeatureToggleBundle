<?php

namespace Hotflo\FeatureToggleBundle\FeatureToggle;

use JoshuaEstes\Component\FeatureToggle\Toggle\FeatureToggleInterface;

class FeatureToggleContainer
{
    /**
     * @var array
     */
    private $featureToggles;

    /**
     * @param array $featureToggles
     */
    public function __construct($featureToggles = array())
    {
        $this->featureToggles = $featureToggles;
    }

    /**
     * Add feature toggle to the container
     *
     * @param FeatureToggleInterface $featureToggle
     * @param string $name
     *
     * @return $this
     */
    public function addFeatureToggle(FeatureToggleInterface $featureToggle, $name)
    {
        $this->featureToggles[$name] = $featureToggle;

        return $this;
    }

    /**
     * Remove feature toggle from the container
     *
     * @param string $name
     *
     * @return $this
     */
    public function removeFeatureToggle($name)
    {
        if (!$this->hasFeatureToggle($name)) {
            throw new \RuntimeException(sprintf('FeatureToggle with name \'%s\' not found.', $name));
        }

        unset($this->featureToggles[$name]);

        return $this;
    }

    /**
     * Check if feature toggle is available
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasFeatureToggle($name)
    {
        return isset($this->featureToggles[$name]);
    }

    /**
     * Get feature toggle by name
     *
     * @param string $name
     *
     * @return FeatureToggleInterface
     */
    public function getFeatureToggle($name)
    {
        if (!$this->hasFeatureToggle($name)) {
            throw new \RuntimeException(sprintf('FeatureToggle with name \'%s\' not found.', $name));
        }

        return $this->featureToggles[$name];
    }

    /**
     * Get all available feature toggles by name
     *
     * @return array
     */
    public function availableFeatureToggles()
    {
        return array_keys($this->featureToggles);
    }
}