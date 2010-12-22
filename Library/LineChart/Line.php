<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\AbstractChartData;


class Line extends AbstractChartData {

    protected $options = array();
    
    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge($this->defaultOptions, array('filled' => false));
        parent::__construct($options);
    }
    
    public function setFilled($filled) {
        $this->options['filled'] = $filled;
    }
    
    public function getFilled() {
        return (boolean) $this->options['filled'];
    }
    
    

    
}
