<?php

namespace GoogleChartGenerator\DataCollection;

abstract class AbstractData {

    //const PRINT_STRATEGY_AUTO = 'auto';
    static $setNumber = 1;
    
    protected $options = [];

    protected $data;

    private static $columnOptions = ['type', 'id', 'label', 'pattern'];

    /**
     * default colors used for data collection when set to auto
     * @var array
     */
//    public static $defaultColours = array('ffa909', '26348c', '4fc400', 'e40613', 'e9d801', 'a71580');

    
    public function __construct($data = null, $options = []) {
        $this->options = array_merge([
//                'color'         => 'auto',
//                'title'         => 'Data title #' . self::$setNumber++,
                //'printStrategy' => self::PRINT_STRATEGY_AUTO,
            ],
            $options
        );

        $this->data = $data;
    }

    public function setOption($name, $value) {
        $this->options[$name] = $value;
    }

    public function getOption($name) {
        return $this->options[$name];
    }

    public function getOptions() {
        return array_diff_key($this->options, array_flip(self::$columnOptions));
    }

    public function getColumnOptions() {
        return array_intersect_key($this->options, array_flip(self::$columnOptions));
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
