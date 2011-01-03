<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\AbstractChart;

abstract class AbstractAxisChart extends AbstractChart {

    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge(
            array('axis' => array (
                'x' => new Axis(),
                'y' => new Axis(),
            )),
            $this->defaultOptions
        );
        parent::__construct($options);
    }
    
    public function getAxis() {
        return $this->options['axis'];
    }
    
    
    protected function getUrlParts() {
        return array_merge(
            parent::getUrlParts(),
            array (
                'chxt' =>  $this->getAxisUrlPart(),
                'chxr' =>  $this->getScaleUrlPart(),
            )
        );
    }
    
    protected function getAxisUrlPart() {
        $axisArray = array();
        foreach ($this->getAxis() as $position => $axis) {
            if ($axis->isEnabled()) {
                $axisArray[] = $position;
            }
        }
        return implode(',', $axisArray);
    }
    
    protected function getScaleUrlPart() {
        //$this->calculateDimensions(); // update chart dimensions
        $scalesArray = array();
        $disabledAxis = $index = 0;
        foreach ($this->getAxis() as $position => $axis) {
            if ($axis->isEnabled() && !$axis->hasDefaultSettings()) {
                if ($axis->getMax() == 'auto' || $axis->getMin() == 'auto') {
                    list($min, $max) = $this->calculateDimensions($position);
                }
                $scalesArray[] = 
                    ($index - $disabledAxis) . ',' .
                    ($axis->getMin() == 'auto' ? $min : $axis->getMin()) . ',' . 
                    ($axis->getMax() == 'auto' ? $max : $axis->getMax());
                
            } elseif (!$axis->isEnabled()) {
                $disabledAxis++;
            }
            $index++;
        }
        return implode('|', $scalesArray);
    }
    
    protected function calculateDimensions($position) {
        $min = null;
        $max = null;
        if ($position == 'x' || $position == 't') { // set dimensions for x axis
            foreach ($this->getData() as $collection) {
                $min = is_null($min) ? $collection->getMinX() : min($collection->getMinX(), $min);
                $max = is_null($max) ? $collection->getMaxX() : max($collection->getMaxX(), $max);
            }
            return array($min, $max);
        } elseif ($position == 'y' || $position == 'r') { // set dimensions for y axis
            foreach ($this->getData() as $collection) {
                $min = is_null($min) ? $collection->getMinY() : min($collection->getMinY(), $min);
                $max = is_null($max) ? $collection->getMaxY() : max($collection->getMaxY(), $max);
            }
            return array($min, $max);
        }
        return false;
    }

}

