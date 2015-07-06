<?php

namespace Hotflo\FeatureToggleBundle;

use Hotflo\FeatureToggleBundle\DependencyInjection\Compiler\FeatureToggleCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HotfloFeatureToggleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
    }
}