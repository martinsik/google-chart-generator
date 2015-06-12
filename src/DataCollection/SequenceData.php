<?php

namespace GoogleChartGenerator\DataCollection;


abstract class SequenceData extends AbstractData implements \ArrayAccess, \Countable, \Iterator {

    /**
     * inner pointer positon (used only when iterating data array)
     * @var integer 
     */
    protected $innerPosition = 0;


    public function __construct($data = null, $options = []) {
        parent::__construct($data, array_merge([
            'type' => 'number'
        ], $options));
//        $this->options = array_merge([
                //'title'         => 'call setLabel($title) to change this text',
                //'printStrategy' => self::PRINT_STRATEGY_AUTO,
//            ],
//            $this->options
//        );
        
//        if (!is_array($data) && $data) {
//            $data = array($data);
//        }
    }
    
    
    public function add($value, $index = null) {
//        if (is_array($value) && !is_null($index)) {
//            throw new \InvalidArgumentException ('Use only add(array), add(array, index), add(value) or add(value, index).');
//        }
        if (is_array($value)) {
            if (!is_null($index)) {
                $this->data = array_merge(array_slice($this->data, 0, $index), $value, array_slice($this->data, $index));
            } elseif ($this->data) {
                foreach ($value as $v) {
                    $this->data[] = $v;
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

//    public function getData(array $range = [], $fillEmpty = true) {
//        if (!$range) {
//            return $this->data;
//        }
//
//        $out = [];
//        for ($i = $range[0]; $i < $range[1]; $i++) {
//            $out[$i] =
//        }
//    }
    
    /*public function getData() {
        if ($this->getRevertX()) {
            return array_reverse($this->data);
        } else {
            return $this->data;
        }
    }*/

//    public function getType() {
//        return $this->type;
//    }

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
    
//    public function getMinY() {
//        return min($this->getData());
//    }
//
//    public function getMaxY() {
//        return max($this->getData());
//    }
    
//    public function isSequence() {
//        $keys = $this->getKeys(); //array_keys($dataCollection);
//        if ($keys[count($keys) - 1] == count($keys) - 1) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
    
    
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
