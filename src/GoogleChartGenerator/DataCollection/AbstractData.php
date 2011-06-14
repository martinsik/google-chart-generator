<?php

namespace GoogleChartGenerator\DataCollection;

class AbstractData {

    const PRINT_STRATEGY_AUTO = 'auto';
    
    
    protected $options = array();
    
    protected $data;
    
    /**
     * default colors used for data collection when set to auto
     * @var array
     */
    public static $defaultColours = array('ffa909', '26348c', '4fc400', 'e40613', 'e9d801', 'a71580');

    
    public function __construct($data = null, array $options = array()) {
        $this->options = array_merge(
            array(
                'color'         => 'auto',
                'title'         => 'call setTitle($title) to change this text',
                //'printStrategy' => self::PRINT_STRATEGY_AUTO,
            ),
            $options
        );
        
        if ($data) {
            $this->data = $data;
        }
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
        $colour = ltrim($colour, '#');
        if (preg_match('/[0-9A-F]{2}[0-9A-F]{2}[0-9A-F]{2}/i', $colour)) {
            $this->options['color'] = $colour;
            return true;
        } else {
            throw new \InvalidArgumentException ('Sorry, but the only appropriate color format is "RRGGBB"');
        }
    }
    
    public function getColor() {
        return $this->getColour();
    }
    
    public function getColour() {
        return $this->options['color'];
    }

    public function getData() {
        return $this->data;
    }
    
    public function setPrintStrategy($strategy) {
        $this->options['printStrategy'] = $strategy;
    }
    
    public function getPrintStrategy() {
        return $this->options['printStrategy'];
    }
    /*
    public function applyPrintStrategy($value) {
        if ($this->getPrintStrategy() == 'auto') {
            return round($value);
        }
        throw new Exception('Unknown print strategy.');
    }
*/
    
}
