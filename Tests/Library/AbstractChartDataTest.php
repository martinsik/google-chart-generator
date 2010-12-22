<?php

namespace Bundle\GoogleChartBundle\Tests\Library;


abstract class AbstractChartDataTest extends \PHPUnit_Framework_TestCase {
    
    public function testAdding() {
        
        // add single value
        $this->assertEquals(0, $this->chartData->add(5)); // insert 5
        $this->assertEquals(1, count($this->chartData)); // check data count
        $this->assertEquals(5, $this->chartData[0]); // check the inserted value
        
        // add indexed value
        $this->chartData[2] = 7; // try to insert number 5 to index 2 as it was an ordinary array
        $this->assertEquals(2, count($this->chartData)); // check data count
        $this->assertEquals(11, $this->chartData->add(9, 11)); // add number 9 to index 11
        $this->assertEquals(3, count($this->chartData)); // check data count
        $this->assertEquals(5, $this->chartData[0]); // check index 0
        $this->assertEquals(7, $this->chartData[2]); // check index 2
        $this->assertEquals(9, $this->chartData[11]); // check index 11
        
        
        
    }
}
