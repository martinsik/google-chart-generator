<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\Font;

class Axis {
    
    protected $labels;
    
    protected $enabled;
    
    protected $font;
    
    protected $max = 'auto';
    
    protected $min = 'auto';
    
    public function __construct($labels = 'auto', $font = null) {
        $this->labels = $labels;
        $this->enabled = true;
        $this->font = $font;
    }
    
    public function setLabels($labels) {
        $this->labels = $labels;
    }
    
    public function getLabels() {
        return $this->labels;
    }
    
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }
    
    public function isEnabled() {
        return (boolean) $this->enabled;
    }
    
    public function setFont(Font $font) {
        $this->font = $font;
    }
    
    public function getFont() {
        return $this->font;
    }
    
    public function setMin($min) {
        if ($this->validateDimension($min)) {
            $this->min = $min;
        }
    }
    
    public function getMin() {
        return $this->min;
    }
    
    public function setMax($max) {
        if ($this->validateDimension($max)) {
            $this->max = $max;
        }
    }
    
    public function getMax() {
        return $this->max;
    }
    
    public function hasDefaultSettings() {
        if ($this->min == 0 && $this->max == 100) {
            return true;
        } else {
            return false;
        }
        
    }
    
    protected function validateDimension($value) {
        if ($value != 'auto' && !is_numeric($value)) {
            throw new \InvalidArgumentException('Use only \'auto\' or a numeric value');
        }
        return true;
    }
    
}
