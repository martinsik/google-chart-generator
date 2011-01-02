<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\LineChart\Line;
use Bundle\GoogleChartBundle\Library\Font;
use Bundle\GoogleChartBundle\Library\AbstractAxisChart;

class LineChart extends AbstractAxisChart {
    
    protected $lines = array();
    
    protected $sparkline = false;
    
    /*public function __construct(array $options = array()) {
        
    }*/
    
    public function addLine(Line $line) {
        $this->lines[] = $line;
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
        $series = array ();
        foreach ($this->getData() as $dataCollection) {
            $urlString = '';
            foreach ($dataCollection as $x => $value) {
                $urlString .= $value . ',';
            }
            $series[] = substr($urlString, 0, -1);
        }
        $dataString = implode('|', $series);
        
        if ($this->getChartTypeUrlPart() == 'lxy') {
            return 't:-1|' . $dataString;
        } else {
            return 't:' . $dataString;
        }
    }

    protected function getChartSpecificUrlPart() {
        
    }
    

    
}
