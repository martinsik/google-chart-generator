<?php

namespace Bundle\GoogleChartBundle\Library\Chart;

use Bundle\GoogleChartBundle\Library\Axis;
use Bundle\GoogleChartBundle\Library\DataCollection\AbstractChartData;

abstract class AbstractChart {
    
    protected $options = array();
    
    protected $data = array();
    
    protected $defaultOptions = array();
    
    static protected $chartNumber = 1;
    
    
    public function __construct(array $options = array()) {
        
        $this->defaultOptions = array_merge(
            $this->defaultOptions,
            array (
                'title' => 'Chart #' . self::$chartNumber++,
                'size' => array (
                    'width'   => 300,
                    'height'  => 200,
                )
            )
        );

        $this->options = array_merge($this->defaultOptions, $options);
        
    }
    

    protected function getUrlParts() {
        return array(
            'cht'   => $this->getChartTypeUrlPart(),
            'chs'   => $this->getSizeUrlPart(),
            'chd'   => $this->getDataUrlPart(),
            'chtt'  => $this->getTitleUrlPart(),
        );
    }
        
    public function getUrl() {
        //$baseUrl = 'https://chart.googleapis.com/chart?';
        $filteredParts = array();
        $urlParts = $this->getUrlParts();
        foreach ($urlParts as $key => $content) {
            if ($content) {
                $filteredParts[] = $key . '=' . $content;
            }
        }
        return 'https://chart.googleapis.com/chart?' . implode('&', $filteredParts);
    }
    
    public function render() {
        return '<img src="' . $this->getUrl() . '" />';
    }
    
    public function addData(AbstractChartData $cd) {
        $this->data[] = $cd;
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
     * @return boolena   Returns true if new chart size was successfuly set,
     *                   otherwise false
     */
    public function setSize($width, $height = null) {
        // check if the only value is one side of a square (eg. 300)
        if (is_numeric($width) && is_null($height)) { // only the first parameter was specified and it's a number eg. 300
            $size = $width . 'x' . $width;
        } elseif (is_numeric($width) && is_numeric($height)) { // eg. $width = 300, $height = 200
            $size = $width . 'x' . $height;
        } elseif (is_null($height)) { // only the first parameter was specified and it's not a number, eg. 300x200
            $size = $width;
        }
            
        // check if new size has appropriate format
        if (!preg_match('/^[0-9]+x[0-9]+$/i', $size)) {
            throw new \InvalidArgumentException();
        }
        
        list($width, $height) = explode('x', $size);
        
        $this->options['size'] = array(
            'width'   => $width,
            'height'  => $height,
        );
        
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
    }
    
    public function getTitle() {
        return $this->options['title'];
    }
    
    public function debugUrl() {
        return str_replace(array('?', '&'), array("\n    ?", "\n    &"), $this->getUrl());
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
    
    
    abstract protected function getChartTypeUrlPart();
    
    abstract protected function getDataUrlPart();
    
}