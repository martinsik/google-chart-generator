<?php

namespace Bundle\GoogleChartBundle\Library;

interface ChartInterface {
    
    public function render();
    
    public function getImageUrl();
    
    public function setSize($x, $y);
    
    public function getSize();
    
}
