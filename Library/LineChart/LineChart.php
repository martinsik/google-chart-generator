<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\LineChart\Line;
use Bundle\GoogleChartBundle\Library\Chart\AbstractAxisChart;
use Bundle\GoogleChartBundle\Library\Font;
use Bundle\GoogleChartBundle\Library\Axis;

class LineChart extends AbstractAxisChart {
    
    //protected $sparkline = false;
    
    public function __construct(array $options = array()) {
        $this->defaultOptions = array_merge(
            $this->defaultOptions,
            array(
                'sparkline' => false
            )
        );
        parent::__construct($options);
    }
    
    public function addLine(Line $line) {
        $this->addData($line);
    }
    
    public function setSparkline($sparkline) {
        $this->options['sparkline'] = $sparkline;
    }
    
    public function getSparkline() {
        return $this->options['sparkline'];
    }
    
    
    /**
     * Generating URL parts
     */
    
    protected function getChartTypeUrlPart() {
        if ($this->getSparkline()) {
            return 'ls';
        }
        /*$axisEnabled = false;
        foreach ($this->getAxis() as $axis) {
            if ($axis->isEnabled()) {
                $axisEnabled = true;
                break;
            }
        }
        
        if ($axisEnabled) {*/
            return 'lxy';
        /*} else {
            return 'lxy';
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
    
    
}
