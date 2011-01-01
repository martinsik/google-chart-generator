<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\AbstractChart;

abstract class AbstractAxisChart extends AbstractChart {
    
    public function hasXAxe() {
        return $this->options['axes']['x']['enabled'];
    }
    
    public function hasXAxeLabels() {
        return $this->options['axes']['x']['labels'];
    }
    
    public function hasYAxe() {
        return $this->options['axes']['y']['enabled'];
    }
    
    public function hasYAxeLabels() {
        return $this->options['axes']['y']['labels'];
    }
    
}
