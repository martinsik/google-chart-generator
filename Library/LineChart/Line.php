<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\ChartDataInterface;


class Line implements ChartDataInterface {
    
    public function __construct(array $options = array()) {
        
    }
    
    
    /**
     * Implementation of ArrayAccess interface
     */
    public function offsetSet($offset, $value) {
        $this->data[$offset] = $value;
    }
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    
}
