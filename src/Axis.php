<?php

namespace GoogleChartGenerator;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use GoogleChartGenerator\Font;

/**
 * Class representing an anix, supports chaining
 */
class Axis {
    
    const AUTO = 'auto';
    const VERTICAL = 'vertical';
    const HORIZONTAL = 'horizontal';


    protected $options = [];
    
    private $render = false;
    
    protected $dimension;

//    protected $max = self::AUTO;
//
//    protected $min = self::AUTO;
    
    public function __construct($dimension, $options = []) {
        if ($dimension != self::HORIZONTAL && $dimension != self::VERTICAL) {
            throw new \InvalidArgumentException();
        }
        $this->dimension = $dimension;
        $this->options = $options;
    }
    
    public function setAuto($auto) {
        $this->auto = $auto;
        return $this;
    }

    public function isAuto() {
        return (boolean) $this->auto;
    }

    
//    public function setPosition($position) {
//        if (in_array($position, array('x', 'y', 't', 'r'))) {
//            $this->position = $position;
//            return $this;
//        } else {
//            throw new \InvalidArgumentException('Use only "x", "y", "t", "r" for axis position');
//        }
//    }
//
//    public function getPosition() {
//        return $this->position;
//    }

    public function getOption($key, $default = null) {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    public function setOption($name, $value) {
        $this->options[$name] = $value;
        $this->setRender(true);
    }

    public function getOptions() {
        return $this->options;
    }


//    public function setMin($value) {
//        $this->min = intval($value);
//        return $this;
//    }
//
//    public function getMin() {
//        return $this->min;
//    }
//
//    public function setMax($value) {
//        $this->max = intval($value);
//        return $this;
//    }
//
//    public function getMax() {
//        return $this->max;
//    }

    public function setRender($value) {
        $this->render = boolval($value);
        return $this;
    }

    public function getRender() {
        return $this->render;
    }
    
    
//    public function hasDefaultSettings() {
//        return ($this->min == self::AUTO && $this->max == self::AUTO);
//    }

    public function getDimension() {
        return $this->dimension;
    }

    public function isVertical() {
        return $this->dimension == self::VERTICAL;
    }
    
    public function isHorizontal() {
        return $this->dimension == self::HORIZONTAL;
    }
    
    /*public function hasToPrint() {
        if ($this->min == 0 && $this->max == 100) {
            return $this->isEnabled();
        } else {
            return false;
        }
    }*/
    
}
