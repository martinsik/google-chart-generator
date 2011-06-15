<?php

namespace GoogleChartGenerator\Chart\LineChart;

use GoogleChartGenerator\DataCollection\AbstractSequenceDataTestCase;
use GoogleChartGenerator\Chart\LineChart\Line;

class LineTest extends AbstractSequenceDataTestCase {
    
    public function setUp() {
        $this->chartData = new Line();
    }
    
    /*public function testDefaultOptions() {
        $this->assertFalse($this->chartData->getFilled());
    }*/
    
    public function testFilled() {
        $this->chartData->setFilled(true);
        $this->assertTrue($this->chartData->getFilled()); // should be true
        
        $this->chartData->setFilled(false);
        $this->assertFalse($this->chartData->getFilled()); // should be false
    }
    
    public function testWidth() {
        $this->chartData->setWidth(100);
        $this->assertEquals(100, $this->chartData->getWidth());
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testWidthException() {
        $this->chartData->setWidth('wrong');
    }
    
    public function testNormalized() {
        $this->chartData->setNormalized(true);
        $this->assertTrue($this->chartData->getNormalized());
        
        $this->chartData->setNormalized(false);
        $this->assertFalse($this->chartData->getNormalized());
    }
    
}
