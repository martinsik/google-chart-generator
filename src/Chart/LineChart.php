<?php

namespace GoogleChartGenerator\Chart;

use GoogleChartGenerator\Chart\AbstractAxisChart;
use GoogleChartGenerator\Chart\LineChart\Line;
use GoogleChartGenerator\Font;
use GoogleChartGenerator\Axis;

class LineChart extends AbstractAxisChart {
    
    //protected $sparkline = false;
    
    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge(
            $this->defaultOptions, [
//                'sparkline' => false
            ]
        );
        parent::__construct($options);
    }
    
//    public function addLine(Line $line) {
//        $this->addData($line);
//    }
    
//    public function setSparkline($sparkline) {
//        $this->setOption('sparkline', $sparkline);
//    }
//
//    public function getSparkline() {
//        return $this->getOption('sparkline');
//    }

    protected function getType() {
        return 'line';
    }
    
    
    
    /**
     * Generating URL parts
     */
//    protected function getChartTypeUrlPart() {
//        if ($this->getSparkline()) {
//            return 'ls';
//        }
        /*$axisEnabled = false;
        foreach ($this->getAxis() as $axis) {
            if ($axis->isEnabled()) {
                $axisEnabled = true;
                break;
            }
        }
        
        if ($axisEnabled) {*/
//            return 'lxy';
        /*} else {
            return 'lxy';
        }*/
//    }
    
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
    
    protected function getScalesUrlPart() {
        /**
         * IMPORTANT NOTE: At this moment scaling y axis is not available
         * All values are automaticly recalculated to the scale of 0-100
         */
        $hasCustom = false;
        $urlString = '';
        list($min, $max) = $this->getXDimensions();
        foreach ($this->getData() as $dataCollection) {
            if (!$dataCollection->isSequence()) {
                $hasCustom = true;
                break;
            }
        }
        
        if (!$hasCustom) {
            return false;
        }
        
        foreach ($this->getData() as $dataCollection) {
            $urlString .= $min . ',' . $max . ',0,100,';
        }
        
        return trim($urlString, ',');
    }
    
    protected function getUrlParts() {
        return array_merge(
            parent::getUrlParts(),
            array (
                'chls' =>  $this->getLineStylesUrlPart(),
                'chds' =>  $this->getScalesUrlPart(),
            )
        );
    }

    /**
     * In the case we're generating sparkline, disable axis
     */
    protected function getAxisUrlPart() {
        if ($this->getSparkline()) {
            return null;
        } else {
            return parent::getAxisUrlPart();
        }
    }
    
    /**
     * In the case we're generating sparkline, disable grid
     */
    protected function getGridUrlPart() {
        if ($this->getSparkline()) {
            return null;
        } else {
            return parent::getGridUrlPart();
        }
    }


    protected function getDataUrlPart() {
        //$series = array();
        $dataString = $this->getDataFormatSign() . ':';
        $chartType = $this->getChartTypeUrlPart();
        list($min, $max) = $this->getYDimensions();
        $range = $max - $min;
        
        list($xmin, $xmax) = $this->getXDimensions();
//        $xrange = $xmax - $xmin;
//        if ($xmax > 61) {
//            $this->setDataFormat(self::DATAFORMAT_TEXT);
//        }
        
        //var_dump($chartType);
        foreach ($this->getData() as $dataCollection) {
            // check if the collection keys are in order
            
            $valuesString = $keysString = '';
            $data = $this->getRevertX() ? array_reverse($dataCollection->getData()) : $dataCollection->getData();
            
            foreach ($data as $x => $value) {
                if (!$dataCollection->isSequence() && $chartType == 'lxy') {
                    if ($this->getDataFormat() == self::DATAFORMAT_TEXT) {
                        $keysString .= $x . ',';
                    } else {
                        $keysString .= $this->encodeValue($x / $xmax);
                    }
                }
                //$valuesString .= $dataCollection->applyPrintStrategy(($value - $min) * 100 / $range) . ',';
                $valuesString .= $this->encodeValue(($value - $min) / $range);
            }
            
           // if ($this->getDataFormat() == self::DATAFORMAT_TEXT) {
            if ($keysString) {
                $dataString .= trim($keysString, ',|');
            } else {
                $dataString .= $this->getDataFormat() == self::DATAFORMAT_TEXT ? '-1' : '_';
            }
            
            //add dataset separator
            $dataString .= $this->getDataFormat() == self::DATAFORMAT_TEXT ? '|' : ',';
            
            //}
            $dataString .= trim($valuesString, ',') . ($this->getDataFormat() == self::DATAFORMAT_TEXT ? '|' : ',');
            //$dataString .= ($keysString ? trim($keysString, ',') : '-1') . '|' . trim($valuesString, ',') . '|';
            
            //$series[] = array($keysString ? $keysString : '-1|', substr($valuesString, 0, -1));
        }
        
        //$dataString = implode($this->getChartTypeUrlPart() == 'lxy' ? '|-1|' : '|', $series);
        
//        return trim($dataString, '|,');
        
    }
    
    
}
