<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\AbstractChart;

abstract class AbstractAxisChart extends AbstractChart {

    public function __construct(array $options = array()) {
        $defaultXAxis = new Axis();
        $defaultXAxis->setMin(0);
        
        $this->defaultOptions = array_merge(
            array('axis' => array (
                'x' => $defaultXAxis,
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
                // if scale is set to 'auto' get minimal and maximal values found among all collections
                if ($axis->getMax() == 'auto' || $axis->getMin() == 'auto') {
                    list($min, $max) = $this->calculateDimensions($position);
                }
                $scalesArray[] = 
                    ($index - $disabledAxis) . ',' . // skip disabled axis
                    ($axis->getMin() == 'auto' ? $min : $axis->getMin()) . ',' . 
                    ($axis->getMax() == 'auto' ? $max : $axis->getMax());
                
            } elseif (!$axis->isEnabled()) {
                $disabledAxis++;
            }
            $index++;
        }
        if ($scalesArray) {
            return implode('|', $scalesArray);
        } else {
            return null;
        }
    }
    
    /**
     * Get minimum and maximum values among all data collections for particular axis
     * 
     * @param string $position  Particular axis (only x, y, right, top)
     * @return array            Returns array(min, max)
     */
    protected function calculateDimensions($position) {
        if ($position != 'x' && $position != 'y' && $position != 'right' && $position != 'top') {
            throw new \InvalidArgumentException('Invalid axis, use only x, y, right or top');
        }
        $min = null;
        $max = null;
        if ($position == 'x' || $position == 't') { // set dimensions for x axis
            foreach ($this->getData() as $collection) {
                $min = is_null($min) ? $collection->getMinX() : min($collection->getMinX(), $min);
                $max = is_null($max) ? $collection->getMaxX() : max($collection->getMaxX(), $max);
            }
        } elseif ($position == 'y' || $position == 'r') { // set dimensions for y axis
            foreach ($this->getData() as $collection) {
                $min = is_null($min) ? $collection->getMinY() : min($collection->getMinY(), $min);
                $max = is_null($max) ? $collection->getMaxY() : max($collection->getMaxY(), $max);
            }
        }
        return array($min, $max);
    }

}

