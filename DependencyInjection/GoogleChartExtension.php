<?php

namespace Bundle\GoogleChartBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class GoogleChartExtension extends Extension {
    
    public function load(array $config, ContainerBuilder $container) {
        if (!$container->hasDefinition('twig.extension.google_chart')) {
            $definition = new Definition('Bundle\GoogleChartBundle\Extension\DebugExtension');
            $definition->addTag('twig.extension');
            $container->setDefinition('twig.extension.google_chart', $definition);
        }
    }

}
