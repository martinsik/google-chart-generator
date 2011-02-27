<?php

namespace Bundle\GoogleChartBundle\Library\BarChart;

use Bundle\GoogleChartBundle\Library\Chart\AbstractAxisChart;
use Bundle\GoogleChartBundle\Library\Axis;

class BarChart extends AbstractAxisChart {
    
    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge(
            $this->defaultOptions,
            array (
                'position' => 'vertical',
                'stacked'  => false,
            )
        );
        
        parent::__construct($options);
        
        if ($this->isVertical()) {
            $this->getGrid()->setBlocksX(false);
        } elseif ($this->isHorizontal()) {
            $this->getGrid()->setBlocksY(false);
            //$this->getXAxis()->setMin(0);
            //$this->getYAxis()->setMin(Axis::AUTO);
        }
    }
    
    protected function getChartTypeUrlPart() {
        if ($this->isVertical() && $this->isStacked()) {
            return 'bvs';
        } elseif ($this->isVertical() && !$this->isStacked()) {
            return 'bvg';
        } elseif ($this->isHorizontal() && $this->isStacked()) {
            return 'bhs';
        } elseif ($this->isHorizontal() && !$this->isStacked()) {
            return 'bhg';
        }
    }
    
    /*protected function getDataUrlPart() {
        $dataString = parent::getDataUrlPart();
        return str_replace('-1|', '', $dataString);
    }*/
    
    public function setPosition($position) {
        $this->options['position'] = $position;
    }
    
    public function getPosition() {
        return $this->options['position'];
    }
    
    public function isVertical() {
        return $this->options['position'] == 'vertical';
    }
    
    public function isHorizontal() {
        return $this->options['position'] == 'horizontal';
    }
    
    public function setStacked($stacked) {
        $this->options['stacked'] = $stacked;
    }
    
    public function isStacked() {
        return (bool) $this->options['stacked'];
    }
    
    
    protected function getDataUrlPart() {
        //$series = array();
        $dataString = 't:';
        //$chartType = $this->getChartTypeUrlPart();
        list($min, $max) = /*$this->isVertical() ? */$this->getYDimensions()/* : $this->getXDimensions()*/;
        $range = $max - $min;
        //var_dump($min, $max);
        
        foreach ($this->getData() as $dataCollection) {
            $data = array();
            foreach ($dataCollection->getData() as $x => $value) {
                $data[] = $dataCollection->applyPrintStrategy(($value - $min) * 100 / $range);
            }
            
            $dataString .= implode(',', $data) . '|';
            
            //$series[] = array($keysString ? $keysString : '-1|', substr($valuesString, 0, -1));
        }
        
        //$dataString = implode($this->getChartTypeUrlPart() == 'lxy' ? '|-1|' : '|', $series);
        
        return trim($dataString, '|');
        
    }
    
    /**
     * Get minimum and maximum values among all data collections for particular axis
     */
    protected function calculateAxisDimensions($dimension) {
        
        /*if ($this->isStacked() && ($this->isHorizontal() && $dimension == 'vertical')) {
            return parent::calculateAxisDimensions('horizontal');
        } else*/ if ($this->isStacked() && $dimension == 'vertical' /* && (($this->isVertical() && $dimension == 'vertical') || ($this->isHorizontal() && $dimension == 'horizontal'))*/) {
            //if (($this->isVertical() && $dimension == 'horizontal') || ($this->isHorizontal() && $dimension == 'vertical')) {
                //return parent::calculateAxisDimensions($dimension == 'horizontal' ? 'vertical' : 'horizontal');
            //    return parent::calculateAxisDimensions($dimension);
            //} else {
            //if (($this->isVertical() && $dimension == 'vertical') || ($this->isHorizontal() && $dimension == 'horizontal')) {
                $sumedCollections = array();
                foreach ($this->getData() as $collection) {
                    foreach ($collection as $x => $value) {
                        if (!isset($sumedCollections[$x])) {
                            $sumedCollections[$x] = 0;
                        }
                        $sumedCollections[$x] += $value;
                    }
                }

                //if (($dimension == 'vertical' && $this->isVertical()) || ($dimension == 'horizontal' && $this->isHorizontal())) {
                    $min = min($sumedCollections);
                    $max = max($sumedCollections);
                    foreach ($this->getAxis() as $axis) {
                        if ($axis->isVertical()/* && $this->isVertical()) || ($axis->isHorizontal() && $this->isHorizontal())*/) {
                            $min = $axis->getMin() === Axis::AUTO ? $min : $axis->getMin();
                            $max = $axis->getMax() === Axis::AUTO ? $max : $axis->getMax();
                        }
                    }
                    return array($min, $max);
                //} else {
                //    $keys = array_keys($sumedCollections);
                //    return array(min($keys), max($keys));
                //}
            //}
            //return array($min, $max);
        } else {
            return parent::calculateAxisDimensions($dimension);
        }
    }
    
    protected function getAxisUrlPart() {
        return $this->isHorizontal() ? strrev(parent::getAxisUrlPart()) : parent::getAxisUrlPart();
        //var_dump($this->isHorizontal());
        //return $this->isHorizontal() && !$this->isStacked() ? strrev(parent::getAxisUrlPart()) : parent::getAxisUrlPart();
    }

    
}

