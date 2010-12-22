<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\LineChart\Line;
use Bundle\GoogleChartBundle\Library\AbstractChart;

class LineChart extends AbstractChart {
    
    protected $lines = array();
    
    public function __construct(array $options = array()) {
        
    }
    
    public function addLine(Line $line) {
        $this->lines[] = $line;
    }
    
    public function getUrl() {
        
    }
    
}
