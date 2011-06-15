<?php

namespace GoogleChartGenerator\DataCollection;

use GoogleChartGenerator\DataCollection\AbstractChartDataTestCase;

abstract class AbstractSequenceDataTestCase extends AbstractChartDataTestCase {

    public function testAddingSingleData() {
        // add single value
        $this->chartData->add(5); // insert 5
        $this->assertEquals(1, count($this->chartData)); // check data count
        $this->assertEquals(5, $this->chartData[0]); // check the inserted value
    }
    
    public function testAddingIndexedData() {
        // add indexed value
        $this->chartData[2] = 7; // try to insert number 7 to index 2 as it was an ordinary array
        $this->assertEquals(1, count($this->chartData)); // check data count
        
        $this->chartData->add(9, 11); // add number 9 to index 11
        $this->assertEquals(2, count($this->chartData)); // check data count
        $this->assertEquals(7, $this->chartData[2]); // check index 2
        $this->assertEquals(9, $this->chartData[11]); // check index 11
    }
    
    public function testRemovingData() {
        $this->chartData->add(array(1, 2, 3, 4, 5));

        unset($this->chartData[0]); // remove first item from the data collection
        $this->assertEquals(4, count($this->chartData)); // check data count
        $this->assertFalse(isset($this->chartData[0])); // make sure removed item doesn't exists

        $this->chartData->removeAll();
        $this->assertEquals(0, count($this->chartData)); // check data count
        $this->chartData->removeAll();
        $this->assertEquals('auto', $this->chartData->getColor()); // make sure that default color is set to auto
    }
    
    public function testAddingArrayData() {
        $this->chartData->add(array(100, 101, 102, 103)); // add array to an empty collection
        $this->chartData->add(array(200, 201, 202, 203));
        $this->assertEquals(8, count($this->chartData)); // check data count
    }
    
    
    public function testIteration() { // try traverse added data
        $array = array(100, 101, 102, 103);
        $this->chartData->add($array);
        foreach ($this->chartData->getData() as $index => $value) {
            $this->assertEquals($array[$index], $value);
        }
    }
    
    public function testMinMaxX() {
        $this->chartData->add(array(2, 3, 4, 5, 8));
        $this->assertEquals(4, $this->chartData->getMaxX()); // check maximum X value
        $this->assertEquals(0, $this->chartData->getMinX()); // check minimum X value
    }
    
    public function testMinMaxY() {
        $this->chartData->add(array(2, 3, 4, 5, 8));
        $this->assertEquals(8, $this->chartData->getMaxY()); // check maximum Y value
        $this->assertEquals(2, $this->chartData->getMinY()); // check minimum Y value
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testAddArrayException() {
        $this->chartData->add(array(100, 101, 102, 103), 2); // rise an exception
    }

}
