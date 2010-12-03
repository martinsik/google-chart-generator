<?php

namespace Bundle\GoogleChartBundle\Library;

abstract class AbstractChartData implements \ArrayAccess, \Countable, \Iterator {
    
    protected $title;
    
    protected $color;
    
    protected $data;
    
    protected $innerPosition = 0;
    
    protected $defaultColors = array('FF0000', '00FF00', '0000FF');
    
    
    public function __construct(array $options = array()) {
        $this->innerPosition = 0;
    }
    
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
    
    
    /**
     * Implementation of ArrayAccess interface
     */
    public function offsetSet($offset, $value) {
        $this->data[$offset] = $value;
    }
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }
    
    /**
     * Implementation of Countable interface
     */
    public function count() {
        return count($this->data);
    }
    
    /**
     * Implementation of Iterator interface
     */
    function rewind() {
        $this->innerPosition = 0;
    }
    function current() {
        return $this->data[$this->innerPosition];
    }
    function key() {
        return $this->innerPosition;
    }
    function next() {
        ++$this->innerPosition;
    }
    function valid() {
        return isset($this->data[$this->innerPosition]);
    }

    
}
