<?php

namespace Bundle\GoogleChartBundle\Library\BarChart;

use Bundle\GoogleChartBundle\Library\Chart\AbstractAxisChart;

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
    
    protected function getDataUrlPart() {
        $dataString = parent::getDataUrlPart();
        return str_replace('-1|', '', $dataString);
    }
    
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
    
    public function setStacked(boolean $stacked) {
        $this->options['stacked'] = $stacked;
    }
    
    public function isStacked() {
        return (bool) $this->options['stacked'];
    }

    
}
