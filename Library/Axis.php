<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\Font;

class Axis {
    
    protected $position;
    
    protected $labels;
    
    protected $enabled;
    
    protected $font;
    
    public function __construct($position, $labels = 'auto', $font = null) {
        if (!in_array($position, array('x', 'y', 'top', 'right'))) {
            throw new \InvalidArgumentException('Allowed values are only: x, y, top, right');
        }
        $this->position = $position;
        $this->labels = $labels;
        $this->enabled = true;
        $this->font = $font;
    }
    
    public function getPosition() {
        return $this->position;
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
    
}
