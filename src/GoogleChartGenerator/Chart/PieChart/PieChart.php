<?php

namespace GoogleChartGenerator\Chart\PieChart;

use GoogleChartGenerator\Chart\AbstractChart;

class PieChart extends AbstractChart {
    
    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge(
            $this->defaultOptions,
            array(
                '3d'     => false,
                'angle'  => 0,
            )
        );
        parent::__construct($options);
        
    }
    
    public function set3d($bool) {
        $this->options['3d'] = $bool;
    }
    
    public function is3d() {
        return $this->options['3d'];
    }
    
    public function setOrientation($angle) {
        $this->options['angle'] = $angle;
    }
    
    public function getOrientation() {
        return $this->options['angle'];
    }
    
    protected function getChartTypeUrlPart() {
        if ($this->is3d()) {
            return 'p3';
        } else {
            return 'p';
        }
    }
    
    protected function getOrientationUrlPart() {
        return $this->options['angle'] ? $this->options['angle'] : false;
    }
    
    protected function getDataUrlPart() {
        $dataParts = array();
        foreach ($this->getData() as $dataCollection) {
            $dataParts[] = $dataCollection->getData();
        }
        return 't:' . implode(',', $dataParts);
    }
    
    protected function getUrlParts() {
        return array_merge(
            parent::getUrlParts(),
            array (
                'chp' =>  $this->getOrientationUrlPart(),
            )
        );
    }
    
}
