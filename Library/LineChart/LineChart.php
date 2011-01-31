<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\LineChart\Line;
use Bundle\GoogleChartBundle\Library\Chart\AbstractAxisChart;
use Bundle\GoogleChartBundle\Library\Font;

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
        //$series = array();
        $dataString = 't:';
        $chartType = $this->getChartTypeUrlPart();
        list($min, $max) = $this->getYDimensions();
        $range = $max - $min;
        //var_dump($chartType);
        foreach ($this->getData() as $dataCollection) {
            // check if the collection keys are in order
            $keys = $dataCollection->getKeys(); //array_keys($dataCollection);
            if ($keys[count($keys) - 1] == count($keys) - 1) {
                $continous = true;
            } else {
                $continous = false;
            }
            
            $valuesString = $keysString = '';
            $data = $dataCollection->getData();
            foreach ($data as $x => $value) {
                if (!$continous && $chartType == 'lxy') {
                    $keysString .= $x . ',';
                }
                $valuesString .= $dataCollection->applyPrintStrategy(($value - $min) * 100 / $range) . ',';
            }
            
            $dataString .= ($keysString ? trim($keysString, ',') : '-1') . '|' . trim($valuesString, ',') . '|';
            
            //$series[] = array($keysString ? $keysString : '-1|', substr($valuesString, 0, -1));
        }
        
        //$dataString = implode($this->getChartTypeUrlPart() == 'lxy' ? '|-1|' : '|', $series);
        
        return trim($dataString, '|');
        
        //return 't:' . $dataString;
        /*if ($chartType == 'lxy') {
            //return 't:-1|' . $dataString;
            return trim($dataString, '|');
        } else {
            //return 't:' . $dataString;
            return $dataString;
        }*/
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
