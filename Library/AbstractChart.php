<?php

namespace Bundle\GoogleChartBundle\Library;

abstract class AbstractChart {
    
    protected $options = array();
    
    static protected $chartNumber = 1;
    
    public function __construct(array $options = array()) {
        
        $defaultOptions = array (
            'size' => array (
                'width'   => 300,
                'height'  => 200,
            ),
            'title' => 'Chart #' . $chartNumber++,
        );

        $this->options = array_merge($defaultOptions, $options);
        
                
    }
    
    public function render() {
        return '<img src="' . $this->getUrl() . '" />';
    }
    
    abstract public function getUrl();
    
    /**
     * Sets chart output size in pixels
     * correct is eg. 300x200, 5x100, 300 (guesses 300x300)
     * incorrect is eg. x300, 300x, 0, 0x0, 500px
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
            return false;
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
    
}
