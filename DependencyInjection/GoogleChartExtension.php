<?php

namespace Bundle\GoogleChartBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bundle\GoogleChartBundle\Extension\DebugExtension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class GoogleChartExtension extends Extension {
    
    public function debugLoad($config, ContainerBuilder $container) {
        $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
        $loader->load('googleChart.xml');
    }
    
    public function getXsdValidationBasePath()
    {
        return null;
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