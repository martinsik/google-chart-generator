<?php

namespace Bundle\GoogleChartBundle\Library\LineChart;

use Bundle\GoogleChartBundle\Library\DataCollection\SequenceData;


class Line extends SequenceData {
    
    public function __construct($data = array(), array $options = array()) {
        parent::__construct($data, $options);
        $this->options = array_merge(
            array (
                'filled'      => false,
                'normalized'  => false,
                'width'       => 1,
            ),
            $this->options
        );

    }
    
    public function setFilled($filled) {
        $this->options['filled'] = $filled;
    }
    
    public function getFilled() {
        return (boolean) $this->options['filled'];
    }
    
    public function setWidth($width) {
        if (!is_numeric($width)) {
            throw new \InvalidArgumentException('Use only numeric value');
        }
        $this->options['width'] = $width;
    }
    
    public function getWidth() {
        return $this->options['width'];
    }
    
    
    /* not implemented yet */
    /**
     * When set to true, all values for this line are recalculated to fit whole chart height
     * @param boolean $normalized
     */
    public function setNormalized($normalized) {
        $this->options['normalized'] = $normalized;
    }
    
    public function getNormalized() {
        return (boolean) $this->options['normalized'];
    }
    
}
