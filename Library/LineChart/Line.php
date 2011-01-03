<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\AbstractChartData;


class Line extends AbstractChartData {
    
    /**
     * Specific options for Line chart:
     *     type: (default: 
     * 
     * @var type 
     */
    protected $options = array();
    
    
    public function __construct(array $options = array()) {
        parent::__construct($options);
        $this->options = array_merge(
            array (
                'filled'      => false,
                'normalized'  => false,
            ), $this->options
        );
    }
    
    public function setFilled($filled) {
        $this->options['filled'] = $filled;
    }
    
    public function isFilled() {
        return (boolean) $this->options['filled'];
    }
    
    public function setNormalized($normalized) {
        $this->options['normalized'] = $normalized;
    }
    
    public function isNormalized() {
        return (boolean) $this->options['normalized'];
    }
    
}
