<?php

namespace Bundle\GoogleChartBundle\Library\Chart;

use Bundle\GoogleChartBundle\Library\Chart\AbstractChart;
use Bundle\GoogleChartBundle\Library\Axis;
use Bundle\GoogleChartBundle\Library\Grid;

abstract class AbstractAxisChart extends AbstractChart {

    public function __construct(array $options = array()) {
        $yAxis = new Axis('y');
        $yAxis->setMin(0);
        
        $this->defaultOptions = array_merge(
            $this->defaultOptions,
            array(
                'axis' => array (
                    new Axis('x'),
                    $yAxis,
                ), 'grid' => new Grid(),
            )
        );
        parent::__construct($options);
    }
    
    public function getAxis() {
        return $this->options['axis'];
    }
    
    public function getXAxis() {
        return $this->_getAxis('x');
    }
    
    public function getYAxis() {
        return $this->_getAxis('y');
    }
    
    public function getGrid() {
        return $this->options['grid']; 
    }
    
    /**
     * Get first axis for specified dimension
     * 
     * @param type $position
     * @return type 
     */
    protected function _getAxis($position) {
        foreach ($this->options['axis'] as &$axis) {
            if ($axis->getPosition() == $position) {
                return $axis;
            }
        }
    }
    
    
    protected function getUrlParts() {
        return array_merge(
            parent::getUrlParts(),
            array (
                'chxt' => $this->getAxisUrlPart(), // visible axes
                'chxr' => $this->getAxisRangeUrlPart(), // axis range
                'chg'  => $this->getGridUrlPart(),
            )
        );
    }
    

    
    /**
     * Visible axes
     * 
     * @return srting  Visible axes url part
     */
    protected function getAxisUrlPart() {
        $axisArray = array();
        foreach ($this->getAxis() as $axis) {
            if ($axis->isEnabled()) {
                $axisArray[] = $axis->getPosition();
            }
        }
        return implode(',', $axisArray);
    }
    
    /**
     * Axis range
     * 
     * @return string
     */
    protected function getAxisRangeUrlPart() {
        //$this->calculateDimensions(); // update chart dimensions
        $scalesArray = array();
        /*$disabledAxis = */$index = 0;
        foreach ($this->getAxis() as $axis) {
            if ($axis->isEnabled() && !$axis->hasDefaultSettings()) {
                // if scale is set to 'auto' get minimal and maximal values found among all collections
                if ($axis->getMax() === Axis::AUTO || $axis->getMin() === Axis::AUTO) {
                    list($min, $max) = $axis->isVertical() ? $this->getYDimensions() : $this->getXDimensions();
                }
                $scalesArray[] = 
                    /*($index - $disabledAxis)*/ $index++ . ',' .
                    ($axis->getMin() === Axis::AUTO ? $min : $axis->getMin()) . ',' . 
                    ($axis->getMax() === Axis::AUTO ? $max : $axis->getMax());
                
            }/* elseif (!$axis->isEnabled()) {
                // each axis has index, we need to know how many disabled axis we want to skip
                $disabledAxis++;
            }*/
        }
        if ($scalesArray) {
            return implode('|', $scalesArray);
        } else {
            return false;
        }
    }
    
    protected function getGridUrlPart() { 
        $grid = $this->getGrid();
        if ($grid->getBlocksX() === 0 && $grid->getBlocksY() === 0) {
            return false;
        } else {
            $blocksX = $grid->getBlocksX() === 'auto' ? $this->autoGridBlocks($this->getSizeX()) : ($grid->getBlocksX() === 0 ? 0 : round(100 / $grid->getBlocksX(), 1));
            $blocksY = $grid->getBlocksY() === 'auto' ? $this->autoGridBlocks($this->getSizeY()) : ($grid->getBlocksY() === 0 ? 0 : round(100 / $grid->getBlocksY(), 1));
            return $blocksX . ',' . $blocksY . ',' . $grid->getLineSegmentLength() . ',' . $grid->getBlankSegmentLength();
        }
        return false;
    }
    
    protected function autoGridBlocks($size) {
        if ($size <= 100) {
            return round(100 / 2, 1);
        } elseif ($size <= 200) {
            return round(100 / 3, 1);
        } elseif ($size <= 350) {
            return round(100 / 4, 1);
        } else {
            return round(100 / ($size / 100), 1);
        }
        
    }
    
    public function getYDimensions() {
        return $this->calculateAxisDimensions('vertical');
    }
    
    public function getXDimensions() {
        return $this->calculateAxisDimensions('horizontal');
    }
    
    /**
     * Get minimum and maximum values among all data collections for particular axis
     */
    protected function calculateAxisDimensions($dimension) {
        
        $min = null;
        $max = null;
        foreach ($this->getAxis() as $axis) {
            //if ($dimension == 'vertical' && ($axis->getPosition() == 'y' || $axis->getPosition() = 'right')) {
            foreach ($this->getData() as $collection) {
                if (($dimension == 'vertical' && ($axis->getPosition() == 'y' || $axis->getPosition() == 'right'))
                        || ($dimension == 'horizontal' && ($axis->getPosition() == 'x' || $axis->getPosition() == 'top'))) {
                    
                    if ($axis->getMin() === Axis::AUTO) {
                        $min = is_null($min) ? ($dimension == 'vertical' ? $collection->getMinY() : $collection->getMinX())
                                             : min(($dimension == 'vertical' ? $collection->getMinY() : $collection->getMinX()), $min);
                    } else {
                        $min = $axis->getMin();
                    }
                    if ($axis->getMax() === Axis::AUTO) {
                        $max = is_null($max) ? ($dimension == 'vertical' ? $collection->getMaxY() : $collection->getMaxX())
                                             :  max(($dimension == 'vertical' ? $collection->getMaxY() : $collection->getMaxX()), $max);
                    } else {
                        $max = $axis->getMax();
                    }
                }
            }
        }
        
        return array($min, $max);
    }
    
    /**
     * @return boolean  True if it's necessary to print this axis
     */
    /*protected function hasToPrint(Axis $axis) {
        return $axis->isEnabled() && !$axis->hasDefaultSettings();
    }*/


}

