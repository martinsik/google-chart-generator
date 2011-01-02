<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\AbstractChart;

abstract class AbstractAxisChart extends AbstractChart {

    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge(
            array(
                'scale' => array(
                    'xmin' => 'auto',
                    'xmax' => 'auto',
                    'ymin' => 'auto',
                    'ymax' => 'auto',
                ),
            ),
            $this->defaultOptions
        );
        parent::__construct($options);
    }

    public function getAxis() {
        return $this->options['axis'];
    }

}
