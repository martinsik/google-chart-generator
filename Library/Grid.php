<?php

namespace Bundle\GoogleChartBundle\Library;

class Grid {
    
    protected $blocksX;
    
    protected $blocksY;
    
    protected $lineSegmentLength;
    
    protected $blankSegmentLength;
    
    //protected $dashed;
    
    
    public function __construct($blocksX = 'auto', $blocksY = 'auto', $lineSegmentLength = 3, $blankSegmentLength = 3) {
        if ($lineSegmentLength != 0 && $blankSegmentLength != 0) {
            $this->dashed = true;
        }
        $this->blocksX = $blocksX;
        $this->blocksY = $blocksY;
        $this->lineSegmentLength = $lineSegmentLength;
        $this->blankSegmentLength = $blankSegmentLength;
    }
    
    public function setBlocksX($blocksX) {
        $this->blocksX = $blocksX;
        return $this;
    }
    
    public function getBlocksX() {
        return $this->blocksX;
    }
    
    public function setBlocksY($blocksY) {
        $this->blocksY = $blocksY;
        return $this;
    }
    
    public function getBlocksY() {
        return $this->blocksY;
    }
    
    public function setLineSegmentLength($length) {
        $this->lineSegmentLength = $length;
        return $this;
    }
    
    public function getLineSegmentLength() {
        return $this->lineSegmentLength;
    }
    
    public function setBlankSegmentLength($length) {
        $this->blankSegmentLength = $length;
        return $this;
    }
    
    public function getBlankSegmentLength() {
        return $this->lineSegmentLength;
    }
    
    
    
    /*public function hasDefaultSettings() {
        return (boolean) $this->lineSegmentLength != 0 && $this->blankSegmentLength != 0;
    }*/
    
}

