<?php

namespace Bundle\GoogleChartBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
//use Bundle\GoogleChartBundle\Extension\DebugExtension;
//use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Definition;

class GoogleChartExtension extends Extension {
    
    public function debugLoad($config, ContainerBuilder $container) {
        if (!$container->hasDefinition('twig.extension.google_chart')) {
            $definition = new Definition('Bundle\GoogleChartBundle\Extension\DebugExtension');
            $definition->addTag('twig.extension');
            $container->setDefinition('twig.extension.google_chart', $definition);
        }
        //$loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
        //$loader->load('googleChart.xml');
    }
    
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/';
    }

    public function getNamespace()
    {
        return 'http://www.example.com/symfony/schema/';
    }

    public function getAlias()
    {
        return 'googleChart';
    }
    
}
