<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\Font;

/**
 * Class representing an anix, supports chaining
 */
class Axis {
    
    const AUTO = 'auto';
    
    /*
     * by default generates automaticly numeric values according to values
     */
    protected $labels;
    
    protected $enabled = true;
    
    protected $position;
    
    /* not implemented yet */
    protected $font;
    
    protected $max = 'auto';
    
    protected $min = 'auto';
    
    public function __construct($position, $labels = 'auto', $font = null) {
        $this->labels = $labels;
        $this->font = $font;
        $this->position = $position;
    }
    
    public function setLabels($labels) {
        $this->labels = $labels;
        return $this;
    }
    
    public function getLabels() {
        return $this->labels;
    }
    
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
        return $this;
    }
    
    public function isEnabled() {
        return (boolean) $this->enabled;
    }
    
    public function setFont(Font $font) {
        $this->font = $font;
        return $this;
    }
    
    public function getFont() {
        return $this->font;
    }
    
    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }
    
    public function getPosition() {
        return $this->position;
    }
    
    public function setMin($min) {
        if ($this->validateDimension($min)) {
            $this->min = $min;
        }
        return $this;
    }
    
    public function getMin() {
        return $this->min;
    }
    
    public function setMax($max) {
        if ($this->validateDimension($max)) {
            $this->max = $max;
        }
        return $this;
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
        return $this->getPosition() == 'y' || $this->getPosition() == 'r';
    }
    
    public function isHorizontal() {
        return $this->getPosition() == 'x' || $this->getPosition() == 't';
    }
    
    /*public function hasToPrint() {
        if ($this->min == 0 && $this->max == 100) {
            return $this->isEnabled();
        } else {
            return false;
        }
    }*/
    
    protected function validateDimension($value) {
        if ($value != 'auto' && !is_numeric($value)) {
            throw new \InvalidArgumentException('Use only \'auto\' or a numeric value');
        }
        return true;
    }
    
}
