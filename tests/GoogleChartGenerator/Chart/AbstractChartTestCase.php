<?php

namespace GoogleChartGenerator\Chart;

abstract class AbstractChartTestCase extends \PHPUnit_Framework_TestCase {
    
    protected $chart;
    
    public function testTitle() {    
        $this->chart->setTitle('my test title');  // change title
        $this->assertEquals('my test title', $this->chart->getTitle()); // check the title
    }
    
}
