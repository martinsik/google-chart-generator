<?php

namespace GoogleChartGenerator\DataCollection;


class SequenceData extends AbstractData implements \ArrayAccess, \Countable, \Iterator {

    /**
     * inner pointer positon (used only when iterating data array)
     * @var integer 
     */
    protected $innerPosition = 0;


    public function __construct($data = null, $options = []) {
        parent::__construct($data, array_merge([
            'type' => 'number'
        ], $options));
    }
    
    
    public function add($value, $index = null, $keepIndies = false) {
//        if (is_array($value) && !is_null($index)) {
//            throw new \InvalidArgumentException ('Use only add(array), add(array, index), add(value) or add(value, index).');
//        }
        if (is_array($value)) {
            if (!is_null($index)) {
                $this->data = array_merge(array_slice($this->data, 0, $index), $value, array_slice($this->data, $index));
            } elseif ($this->data) {
                if ($keepIndies) {
                    foreach ($value as $key => $v) {
                        $this->data[$key] = $v;
                    }
                } else {
                    $this->data = array_merge($this->data, $value);
                }
            } else {
                $this->data = $value;
            }
        } elseif (is_null($index)) {
            $this->data[] = $value;
        } else {
            $this->data[$index] = $value;
        }
        return true;
    }

    public function removeAll() {
        $this->data = [];
    }
    
    public function getKeys() {
        return array_keys($this->data);
    }
    
    public function getMinX() {
        $keys = array_keys($this->getData());
        return min($keys);
    }
    
    public function getMaxX() {
        $keys = array_keys($this->getData());
        return max($keys);
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
