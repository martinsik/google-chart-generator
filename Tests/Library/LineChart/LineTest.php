<?php

namespace Bundle\GoogleChartBundle\Tests\LineChart;

use Bundle\GoogleChartBundle\Tests\Library\AbstractChartDataTest;
use Bundle\GoogleChartBundle\Library\LineChart\Line;

class LineTest extends AbstractChartDataTest {
    
    protected $chartData;
    
    public function setUp() {
        $this->chartData = new Line();
    }
    
    
}
