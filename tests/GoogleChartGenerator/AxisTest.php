<?php

namespace GoogleChartGenerator;

use GoogleChartGenerator\Axis;

class AxisTest extends \PHPUnit_Framework_TestCase {

    protected $axis;
    
    public function setUp() {
        $this->axis = new Axis('x');
    }
    
    public function testDefault() {
        $this->assertEquals('auto', $this->axis->getLabels());
    }
    
    public function testLabels() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setLabels(array(5 => 'label')));
        // test get method
        $this->assertEquals(1, count($this->axis->getLabels()));
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testLabelsException() {
        $this->axis->setLabels('wrong');
    }
    
    public function testEnabled() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setEnabled(false));
        // test is method
        $this->assertFalse($this->axis->isEnabled());
    }
    
    public function testPosition() {
        // test position defined in setUp()
        $this->assertEquals('x', $this->axis->getPosition());
        
        // test get method
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setPosition('y'));
        
        // test set method and chaining
        $this->assertEquals('y', $this->axis->getPosition());
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testPositionException() {
        $this->axis->setPosition('d');
    }
    
    public function testMin() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setMin(10));
        // test get method
        $this->assertEquals(10, $this->axis->getMin());
        
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setMin('auto'));
        // test get method
        $this->assertEquals('auto', $this->axis->getMin());
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testMinException() {
        $this->axis->setMin('wrong');
    }
    
    public function testMax() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setMax(200));
        // test get method
        $this->assertEquals(200, $this->axis->getMax());
        
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Axis', $this->axis->setMax('auto'));
        // test get method
        $this->assertEquals('auto', $this->axis->getMax());
    }
    
    /**
     * @expectedException InvalidArgumentException 
     */
    public function testMaxException() {
        $this->axis->setMin('wrong');
    }
    
    public function testHasDefaultSettings() {
        $this->assertFalse($this->axis->hasDefaultSettings());
        
        $this->axis->setMin(0);
        $this->axis->setMax(100);
        $this->assertTrue($this->axis->hasDefaultSettings());
    }
    
    public function testVertical() {
        $this->axis->setPosition('y');
        $this->assertTrue($this->axis->isVertical());
        $this->axis->setPosition('r');
        $this->assertTrue($this->axis->isVertical());
    }
    
    public function testHorizontal() {
        $this->axis->setPosition('x');
        $this->assertTrue($this->axis->isHorizontal());
        $this->axis->setPosition('t');
        $this->assertTrue($this->axis->isHorizontal());
    }
    
}
