<?php

namespace GoogleChartGenerator\Chart;

use GoogleChartGenerator\Axis;
use GoogleChartGenerator\DataCollection\AbstractData;

abstract class AbstractChart {
    
    const DATAFORMAT_TEXT = 'text';
    const DATAFORMAT_SIMPLE_ENCODING = 'simple';
    
    protected $encodingConsts = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    
    private $options = [];
    
    protected $data = [];
    
    protected $defaultOptions = [];

    private $jsonEncodeFlags = 0;

    private $HTMLTemplate = <<<TEMPLATE
<google-chart
    type='__TYPE__'
    options='__OPTIONS__'
    cols='__COLS__'
    rows='__ROWS__'>
</google-chart>
TEMPLATE;


    static protected $chartNumber = 1;

    
    public function __construct(array $options = []) {
//        $this->defaultOptions = array_merge(
//            $this->defaultOptions, [
//                'title' => 'Chart #' . self::$chartNumber++,
//                'width'   => 300,
//                'height'  => 200,
//                'legend' => false,
//                'dataFormat' => self::DATAFORMAT_SIMPLE_ENCODING,
//            ]
//        );

        $this->options = $options;
//        $this->options = array_merge($this->defaultOptions, $options);
        
//        if (isset($options['size'])) {
//            $this->setSize($options['size']);
//        }
    }
    

    public function getElement() {
        $params = [];
        foreach ($this->getElementParameters() as $key => $values) {
            $params[$key] = is_array($values) ? json_encode($values, $this->jsonEncodeFlags) : $values;
        }
        return str_replace(['__TYPE__', '__OPTIONS__', '__COLS__', '__ROWS__'], $params, $this->HTMLTemplate);
    }

    protected function getElementParameters() {
        return [
            '__TYPE__' => $this->getType(),
            '__OPTIONS__' => $this->getOptions(),
            '__COLS__' => $this->getCols(),
            '__ROWS__' => $this->getRows(),
        ];
    }

    protected function getCols() {
        $cols = [ ['type' => 'number'] ];
        foreach ($this->getData() as $data) {
            /** @var AbstractData $data */
            $col = array_merge(['type' => $data->getType()], $data->getOptions());
            $cols[] = $col;
        }

        return $cols;
    }

    protected function getRows() {
        $rows = [];
        foreach ($this->getData() as $data) {
            /** @var AbstractData $data */
            $rows[] = $data->getData();
        }
        return $rows;
    }

//    protected function getUrlParts() {
//        return array(
//            'cht'   => $this->getChartTypeUrlPart(),
//            'chs'   => $this->getSizeUrlPart(),
//            'chd'   => $this->getDataUrlPart(),
//            'chtt'  => $this->getTitleUrlPart(),
//            'chco'  => $this->getColorsUrlPart(),
//            'chdlp' => $this->getLegendPositionUrlPart(),
//            'chdl'  => $this->getLegendLabelsUrlPart(),
//        );
//    }
        
    public function renderUrl() {
        $filteredParts = array();
        $urlParts = $this->getUrlParts();
        foreach ($urlParts as $key => $content) {
            if ($content) {
                $filteredParts[] = $key . '=' . $content;
            }
        }
        return 'http://chart.googleapis.com/chart?' . implode('&', $filteredParts);
    }
    
    public function render() {
        return '<img src="' . $this->renderUrl() . '" width="' . $this->getSizeX() . '" height="' . $this->getSizeY() . '" alt="' . $this->getTitle() . '" />';
    }
    
//    public function download($filename) {
//        file_put_contents($filename, file_get_contents($this->renderUrl()));
//    }
    
    public function debugUrl() {
        return str_replace(array('?', '&'), array("\n    ?", "\n    &"), $this->renderUrl());
    }
    
    /**
     * Add data to the chart
     * 
     * @param AbstractData|array  $data  Chart data
     */
    public function addData($data) {
        if (is_array($data)) {
            foreach ($data as $collection) {
                $this->addData($collection);
            }
        } elseif ($data instanceof AbstractData) {
            $this->data[] = $data;
        } else {
            throw new \InvalidArgumentException();
        }
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function getOptions() {
        return $this->options;
    }
    
    /**
     * Sets chart output size in pixels
     * correct are eg. 300x200, 5x100, 300 (guesses 300x300)
     * incorrect are eg. x300, 300x, 0, 0x0, 500px
     * 
     * @param integer|string  $x 
     * @param integer         $y 
     * @return boolean   Returns true if new chart size was successfuly set,
     *                   otherwise false
     */
//    public function setSize($width, $height = null) {
//        // check if the only value is one side of a square (eg. 300)
//        if (is_numeric($width) && is_null($height)) { // only the first parameter was specified and it's a number eg. 300
//            $size = $width . 'x' . $width;
//        } elseif (is_numeric($width) && is_numeric($height)) { // eg. $width = 300, $height = 200
//            $size = $width . 'x' . $height;
//        } elseif (is_null($height)) { // only the first parameter was specified and it's not a number, eg. 300x200
//            $size = $width;
//        }
//
//        // check if new size has appropriate format
//        if (!preg_match('/^[0-9]+x[0-9]+$/i', $size)) {
//            throw new \InvalidArgumentException();
//        }
//
//        list($width, $height) = explode('x', $size);
//
//        $this->options['size'] = array(
//            'width'   => $width,
//            'height'  => $height,
//        );
//
//    }

    public function setOption($key, $value) {
        $this->options[$key] = $value;
    }
    
    public function getOption($key, $default = null) {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }
    
    /**
     * Get actual chart size
     * 
     * @return array   return chart size as an associative array containing
     *                 two items: width and height
     */
    public function getSize() {
        return $this->options['size'];
    }
    
    public function getSizeX() {
        return $this->options['size']['width'];
    }
    
    public function getSizeY() {
        return $this->options['size']['height'];
    }
    
    public function setTitle($title) {
        $this->options['title'] = $title;
        return $this;
    }
    
    public function getTitle() {
        return $this->options['title'];
    }
    
    public function setDataFormat($title) {
        $this->options['dataFormat'] = $title;
    }
    
    public function getDataFormat() {
        return $this->options['dataFormat'];
    }
    
    /**
     * Returns single character flag according to selected data format
     * 
     * @return string  data format flag 
     */
    public function getDataFormatSign() {
        if ($this->getDataFormat() == self::DATAFORMAT_TEXT) {
            return 't';
        } elseif ($this->getDataFormat() == self::DATAFORMAT_SIMPLE_ENCODING) {
            return 's';
        }
    }
    
    public function setLegend($legend) {
        if (!in_array($legend, array('l', 'r', 't', 'b', false, true, null))) {
            throw new \InvalidArgumentException();
        }
        $this->options['legend'] = $legend;
    }
    
    public function getLegend() {
        return $this->options['legend'];
    }
    
    
    protected function encodeValue($value) {
        if ($this->getDataFormat() == self::DATAFORMAT_TEXT) {
            return round($value * 100) . ',';
        } elseif ($this->getDataFormat() == self::DATAFORMAT_SIMPLE_ENCODING) {
            return $this->encodingConsts[$value * 61];
        }
    }
    
    protected function getSizeUrlPart() {
        $size = $this->getSize();
        return $size['width'] . 'x' . $size['height'];
    }
    
    protected function getTitleUrlPart() {
        if ($this->options['title']) {
            return urlencode($this->options['title']);
        }
    }
    
    protected function getColorsUrlPart() {
        
        //Allow for gradients based on single chart color
        if (isset($this->options['color'])){ 
            return $this->options['color'];
        }
        
        //Process data colors
        $colours = array();
        $autoColoursIndex = 0;
        foreach ($this->getData() as $collection) {
            $colours[] = $collection->getColour() == 'auto' ? $collection::$defaultColours[$autoColoursIndex++] : $collection->getColour();
        }
        return implode(',', $colours);
    }
    
    protected function getLegendPositionUrlPart() {
        if ($this->options['legend']) {
            foreach ($this->getData() as $collection) {
                if ($collection->getTitle()) {
                    // when legend is set to 'r' we don't need to render it. It's default value.
                    return $this->options['legend'] == 'r' ? false : $this->options['legend'];
                }
            }
        }
        return false;
    }
    
    protected function getLegendLabelsUrlPart() {
        if ($this->options['legend']) {
            $titles = array();
            foreach ($this->getData() as $collection) {
                $titles[] = urlencode($collection->getTitle());
            }
            return implode('|', $titles);
        } else {
            return false;
        }
    }


//    protected function _renderOptions() {
//        $jsOptions = [];
//        if (isset($this->options['title'])) {
//            $jsOptions['title'] = $this->options['title'];
//        }

//        return 'var options = ' . json_encode($this->getOptions(), JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
//    }

    
    abstract protected function getType();
//
//    abstract protected function getDataUrlPart();
    
}
