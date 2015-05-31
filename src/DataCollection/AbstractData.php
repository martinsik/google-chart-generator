<?php

namespace GoogleChartGenerator\DataCollection;

abstract class AbstractData {

    //const PRINT_STRATEGY_AUTO = 'auto';
    static $setNumber = 1;
    
    protected $options = array();
    
    protected $data;
    
    /**
     * default colors used for data collection when set to auto
     * @var array
     */
    public static $defaultColours = array('ffa909', '26348c', '4fc400', 'e40613', 'e9d801', 'a71580');

    
    public function __construct($data = null, array $options = []) {
        $this->options = array_merge([
//                'color'         => 'auto',
                'title'         => 'Data title #' . self::$setNumber++,
                //'printStrategy' => self::PRINT_STRATEGY_AUTO,
            ],
            $options
        );

        $this->data = $data;
    }

    
    public function setTitle($title) {
        $this->options['title'] = $title;
    }
    
    public function getTitle() {
        return $this->options['title'];
    }
    
    public function setColor($colour) {
        $colour = ltrim($colour, '#');
        if (preg_match('/[0-9A-F]{2}[0-9A-F]{2}[0-9A-F]{2}/i', $colour)) {
            $this->options['color'] = $colour;
            return true;
        } else {
            throw new \InvalidArgumentException ('The only allowed color format is hex "RRGGBB"');
        }
    }
    
    public function getColor() {
        return $this->options['color'];
    }

    public function getData() {
        return $this->data;
    }
    /*
    public function setPrintStrategy($strategy) {
        $this->options['printStrategy'] = $strategy;
    }
    
    public function getPrintStrategy() {
        return $this->options['printStrategy'];
    }*/
    /*
    public function applyPrintStrategy($value) {
        if ($this->getPrintStrategy() == 'auto') {
            return round($value);
        }
        throw new Exception('Unknown print strategy.');
    }
*/
    
}
