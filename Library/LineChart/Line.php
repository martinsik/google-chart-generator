<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\AbstractChartData;


class Line extends AbstractChartData {

    protected $options = array();
    
    public function __construct(array $options = array()) {
        parent::__construct($options);
        
        $defaultOptions = array(
            'filled' => false,
            'color'  => 'auto'
        );
    }
    


    
}
