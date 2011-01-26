<?php

namespace Bundle\GoogleChartBundle\Library;

class Grid {
    
    protected $stepX;
    
    protected $stepY;
    
    protected $lineSegmentLength;
    
    protected $blankSegmentLength;
    
    protected $dashed;
    
    
    public function __construct($stepX = 'auto', $stepY = 'auto', $lineSegmentLength = 2, $blankSegmentLength = 2) {
        if ($lineSegmentLength != 0 && $blankSegmentLength != 0) {
            $this->dashed = true;
        }
        $this->stepX = $stepX;
        $this->stepY = $stepY;
        $this->lineSegmentLength = $lineSegmentLength;
        $this->blankSegmentLength = $blankSegmentLength;
    }
    
    public function setStepX($stepX) {
        $this->stepX = $stepX;
    }
    
    public function getStepX() {
        return $this->stepX;
    }
    
    public function setStepY($stepY) {
        $this->stepY = $stepY;
    }
    
    public function getStepY() {
        return $this->stepY;
    }
    
}

