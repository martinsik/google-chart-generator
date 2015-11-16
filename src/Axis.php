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
        return \boolval($this->auto);
    }

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

    public function setRender($value) {
        $this->render = \boolval($value);
        return $this;
    }

    public function getRender() {
        return $this->render;
    }

    public function getDimension() {
        return $this->dimension;
    }

    public function isVertical() {
        return $this->dimension == self::VERTICAL;
    }
    
    public function isHorizontal() {
        return $this->dimension == self::HORIZONTAL;
    }
    
}
