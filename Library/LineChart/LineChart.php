<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\LineChart\Line;
use Bundle\GoogleChartBundle\Library\AbstractAxisChart;

class LineChart extends AbstractAxisChart {
    
    protected $lines = array();
    
    /*public function __construct(array $options = array()) {
        
    }*/
    
    public function addLine(Line $line) {
        $this->lines[] = $line;
    }
    
    
    protected function getChartTypeUrlPart() {
        if ($this->hasXaxe() && $this->hasYaxe()) {
            return 'lc';
        }
    }

    protected function getChartSpecificUrlPart() {
        
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
        return 't:' . implode('|', $series);
    }
    
}
