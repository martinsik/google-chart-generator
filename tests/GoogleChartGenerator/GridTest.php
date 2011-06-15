<?php

namespace GoogleChartGenerator;

use GoogleChartGenerator\Grid;

class GridTest extends \PHPUnit_Framework_TestCase {

    protected $grid;
    
    public function setUp() {
        $this->grid = new Grid();
    }
    
    public function testDefault() {
        $this->assertEquals('auto', $this->grid->getBlocksX());
        $this->assertEquals('auto', $this->grid->getBlocksY());
    }
    
    public function testBlocksX() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Grid', $this->grid->setBlocksX(10));
        // test get method
        $this->assertEquals(10, $this->grid->getBlocksX());
    }
    
    public function testBlocksY() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Grid', $this->grid->setBlocksY(10));
        // test get method
        $this->assertEquals(10, $this->grid->getBlocksY());
    }
    
    public function testLineSegmentLength() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Grid', $this->grid->setLineSegmentLength(10));
        // test get method
        $this->assertEquals(10, $this->grid->getLineSegmentLength());
    }
    
    public function testBlankSegmentLength() {
        // test set method and chaining
        $this->assertInstanceOf('GoogleChartGenerator\Grid', $this->grid->setBlankSegmentLength(10));
        // test get method
        $this->assertEquals(10, $this->grid->getBlankSegmentLength());
    }

}
