<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\LineChart\Line;
use Bundle\GoogleChartBundle\Library\Font;
use Bundle\GoogleChartBundle\Library\AbstractAxisChart;

class LineChart extends AbstractAxisChart {
    
    protected $sparkline = false;
    
    /*public function __construct(array $options = array()) {
        
    }*/
    
    public function addLine(Line $line) {
        $this->addData($line);
    }
    
    public function setSparkline($sparkline) {
        $this->sparkline = $sparkline;
    }
    
    public function getSparkline() {
        return $this->sparkline;
    }
    
    
    protected function getChartTypeUrlPart() {
        if ($this->getSparkline()) {
            return 'ls';
        }
        $axisEnabled = false;
        foreach ($this->getAxis() as $axis) {
            if ($axis->isEnabled()) {
                $axisEnabled = true;
                break;
            }
        }
        
        if ($axisEnabled) {
            return 'lxy';
        } else {
            return 'lc';
        }
    }
    
    protected function getDataUrlPart() {
        $series = array();
        list($min, $max) = $this->getYDimensions();
        $range = $max - $min;
        
        foreach ($this->getData() as $dataCollection) {
            //var_dump($this->getData());
            $urlString = '';
            foreach ($dataCollection as $x => $value) {
                $urlString .= round(($value - $min) * 100 / $range, 3) . ',';
            }
            $series[] = substr($urlString, 0, -1);
        }
        $dataString = implode($this->getChartTypeUrlPart() == 'lxy' ? '|-1|' : '|', $series);
        
        //return 't:' . $dataString;
        if ($this->getChartTypeUrlPart() == 'lxy') {
            return 't:-1|' . $dataString;
        } else {
            return 't:' . $dataString;
        }
    }
    
    protected function getLineStylesUrlPart() {
        $widths = array();
        $needSpecify = false;
        foreach ($this->getData() as $dataCollection) {
            $widths[] = $dataCollection->getWidth();
            if ($dataCollection->getWidth() != 1) {
                $needSpecify = true;
            }
        }
        return $needSpecify ? implode('|', $widths) : false;
    }
    
    
    protected function getUrlParts() {
        return array_merge(
            parent::getUrlParts(),
            array (
                'chls' =>  $this->getLineStylesUrlPart(),
            )
        );
    }
    

    
}
