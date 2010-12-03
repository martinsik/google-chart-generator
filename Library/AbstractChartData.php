<?php

namespace Bundle\GoogleChartBundle\Library;

abstract class AbstractChartData implements \ArrayAccess {
    
    protected $title;
    
    protected $color;
    
    protected $data;
    
    
    public function __construct(array $options = array());
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setColor($color) {
        $this->color = $color;
    }
    
    public function getColor() {
        return $this->color;
    }
    
    
    
}
