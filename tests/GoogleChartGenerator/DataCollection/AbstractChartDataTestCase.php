<?php

namespace GoogleChartGenerator\DataCollection;

abstract class AbstractChartDataTestCase extends \PHPUnit_Framework_TestCase {
    
    protected $chartData;
    
    public function testColor() {
        // changing settings
        $this->chartData->setColour('FF0000'); // set new colour
        $this->assertEquals('FF0000', $this->chartData->getColour()); // check the colour
        $this->chartData->setColor('008800'); // the same but the US version
        $this->assertEquals('008800', $this->chartData->getColor()); //the same but the US version
    }
    
    public function testTitle() {    
        $this->chartData->setTitle('my test title');  // change title
        $this->assertEquals('my test title', $this->chartData->getTitle()); // check the title
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testColourException() {
        $this->chartData->setColour('red'); // rise an exception
    }
    
}
