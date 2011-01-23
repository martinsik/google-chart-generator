<?php

namespace Bundle\GoogleChartBundle\Extension;

/**
 * TwigExtension.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class DebugExtension extends \Twig_Extension {

    public function getFilters()
    {
        return array(
            'print_r'    => new \Twig_Filter_Function('print_r'),
            'nice_dump'  => new \Twig_Filter_Method($this, 'niceDump'),
        );
    }

    public function niceDump($chartUrl) {
        $chartUrl = preg_replace('/([\&|\?])(.*)\=/U', '\1<span class="option">\2</span>=', $chartUrl);
        return $chartUrl;
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'google_chart_debug';
    }

}
