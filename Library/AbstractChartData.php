<?php

namespace Bundle\GoogleChartBundle\Library;

abstract class AbstractChartData implements \ArrayAccess, \Countable, \Iterator {
    
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
    
    protected $defaultOptions = array(
        'colour'    => 'auto',
        'title'     => 'call setTitle($title) to change this text :)',
    );
    
    
    public function __construct(array $options = array()) {
        $this->reset();
        $this->options = array_merge($this->options, $options);
    }
    
    public function setTitle($title) {
        $this->options['title'] = $title;
    }
    
    public function getTitle() {
        return $this->options['title'];
    }
    
    public function setColor($color) {
        return $this->setColour($color);
    }
    
    public function setColour($colour) {
        if (preg_match('/[0-9A-F]{2}[0-9A-F]{2}[0-9A-F]{2}/i', $colour)) {
            $this->options['colour'] = $colour;
            return true;
        } else {
            throw new \InvalidArgumentException ('Sorry, but the only appropriate colour format is "RRGGBB"');
        }
    }
    
    public function getColor() {
        return $this->getColour();
    }
    
    public function getColour() {
        return $this->options['colour'];
    }
    
    public function add($value, $index = null) {
        if (is_array($value) && !is_null($index)) {
            throw new \InvalidArgumentException ('Sorry, but this doesn\'t make sence. Use only add(array), add(value) or add(value, index).');
        }
        if (is_array($value)) {
            $this->data = array_merge($this->data, $value);
        } elseif (is_null($index)) {
            $this->data[] = $value;
        } else {
            $this->data[$index] = $value;
        }
        return true;
    }
    
    public function reset() {
        $this->data = array();
        $this->innerPosition = 0;
        $this->options = $this->defaultOptions;
        /**
         * TODO: reset to default settings (just check it :))
         */
    }
    
    public function removeAll() {
        $this->data = array();
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function getMinX() {
        $keys = array_keys($this->getData());
        return min($keys);
    }
    
    public function getMaxX() {
        $keys = array_keys($this->getData());
        return max($keys);
    }
    
    public function getMinY() {
        return min($this->getData());
    }
    
    public function getMaxY() {
        return max($this->getData());
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
