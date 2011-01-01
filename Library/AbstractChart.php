<?php

namespace Bundle\GoogleChartBundle\Library;

use Bundle\GoogleChartBundle\Library\Axis;

abstract class AbstractChart {
    
    protected $options = array();
    
    protected $data = array();
    
    protected $defaultOptions = array();
    
    static protected $chartNumber = 1;
    
    
    public function __construct(array $options = array()) {
        
        $this->defaultOptions = array (
            'title' => 'Chart #' . self::$chartNumber++,
            'size' => array (
                'width'   => 300,
                'height'  => 200,
            ),
            'axes'  => array (
                'x' => new Axis('x'),
                'y' => new Axis('y'),
            )
        );

        $this->options = array_merge($this->defaultOptions, $options);
        
    }
        
    public function getUrl() {
        $baseUrl = 'https://chart.googleapis.com/chart?';
        $parts = array (
            'cht=' . $this->getChartTypeUrlPart(),
            'chs=' . $this->getSizeUrlPart(),
            'chd=' . $this->getDataUrlPart(),
            $this->getTitleUrlPart() ? 'chtt=' . $this->getTitleUrlPart() : false,
            $this->getChartSpecificUrlPart(),
        );
        return trim($baseUrl . implode('&', $parts), '&');
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
        if (!preg_match('/^[0-9]+x[0-9]+$/i', $width)) {
            throw new InvalidArgumentException();
        }
        
        list($width, $height) = explode('x', $width);
        
        $this->options['size'] = array(
            'width'   => $x,
            'height'  => $y,
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
        } else {
            return false;
        }
    }
    
    abstract protected function getChartTypeUrlPart();
    
    abstract protected function getChartSpecificUrlPart();
    
    abstract protected function getDataUrlPart();
    
}
