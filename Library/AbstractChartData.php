<?php

namespace Bundle\GoogleChartBundle\Library;

abstract class AbstractChartData implements \ArrayAccess, \Countable, \Iterator {
    
    /**
     * data collection title
     * @var string
     */
    protected $title = 'call setTitle($title) to change this text :)';
    
    /**
     * data collection color
     * @var string
     */
    protected $colour = 'auto';
    
    /**
     * data itself
     * @var array
     */
    protected $data = array();
    
    /**
     * inner pointer positon (used only when iterating data array)
     * @var integer 
     */
    protected $innerPosition = 0;
    
    /**
     * default colors used for data collection when set to auto
     * @var array
     */
    protected $defaultColours = array('FF0000', '00FF00', '0000FF');
    
    
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
        return $this->setColour($color);
    }
    
    public function setColour($colour) {
        if (preg_match('/[0-9A-F]{2}[0-9A-F]{2}[0-9A-F]{2}/i', $colour)) {
            $this->colour = $colour;
            return true;
        } else {
            throw new \InvalidArgumentException ('Sorry, but the only appropriate colour format is "RRGGBB"');
        }
    }
    
    public function getColor() {
        return $this->getColour();
    }
    
    public function getColour() {
        return $this->colour;
    }
    
    public function add($value, $key = null) {
        if (is_null($key)) {
            $this->data[] = $value;
            return $this->count() - 1;
        } else {
            $this->data[$key] = $value;
            return $key;
        }
    }
    
    public function reset() {
        $this->data = array();
        $this->color = 'auto';
        $this->innerPosition = 0;
        $this->title = 'call setTitle($title) to change this text :)';
        /**
         * TODO: reset to default settings (just check it :))
         */
    }
    
    public function removeAll() {
        $this->data = array();
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
