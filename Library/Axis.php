<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\Font;

class Axis {
    
    const AUTO = 'auto';
    
    protected $labels;
    
    protected $enabled;
    
    protected $position;
    
    protected $font;
    
    protected $max = 'auto';
    
    protected $min = 'auto';
    
    public function __construct($position, $labels = 'auto', $font = null) {
        $this->labels = $labels;
        $this->enabled = true;
        $this->font = $font;
        $this->position = $position;
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
    
    public function setPosition($position) {
        $this->position = $position;
    }
    
    public function getPosition() {
        return $this->position;
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
    
    public function isVertical() {
        return $this->getPosition() == 'y' || $this->getPosition() == 'right';
    }
    
    public function isHorizontal() {
        return $this->getPosition() == 'x' || $this->getPosition() == 'top';
    }
    
    protected function validateDimension($value) {
        if ($value != 'auto' && !is_numeric($value)) {
            throw new \InvalidArgumentException('Use only \'auto\' or a numeric value');
        }
        return true;
    }
    
}
