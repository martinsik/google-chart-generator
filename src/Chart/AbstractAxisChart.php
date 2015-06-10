<?php

namespace GoogleChartGenerator\Chart;

use GoogleChartGenerator\Chart\AbstractChart;
use GoogleChartGenerator\Axis;
use GoogleChartGenerator\DataCollection\AbstractSequenceDataTestCase;
use GoogleChartGenerator\DataCollection\SequenceData;
use GoogleChartGenerator\Grid;

abstract class AbstractAxisChart extends AbstractChart {

    const STRATEGY_NONE = 'none';
    const STRATEGY_MIN = 'min';
    const STRATEGY_MAX = 'max';
    const STRATEGY_AVERAGE = 'average';

    const DISCRETE = 'string';
    const CONTINUOUS = 'number';
    const DATE = 'date';

    private $axes = [];

    private $mainAxisType = self::DISCRETE;


    public function __construct(array $options = array()) {
        parent::__construct($options);
//        $yAxis =
//        $yAxis->setMin(0);

        $this->axes[] = new Axis(Axis::VERTICAL, ['title' => 'y']);
        $this->axes[] = new Axis(Axis::HORIZONTAL, ['title' => 'x']);

//        $this->defaultOptions = array_merge(
//            $this->defaultOptions, [
////                'grid' => new Grid(),
////                'dataReductionStrategy' => 'none',
////                'revertX'       => false,
////                'revertY'       => false, // not implemented yet
//            ]
//        );
    }

    protected function getRows() {
        $rows = [];
        list($minX, $maxX) = $this->getXDimensions();
//        list($minY, $maxY) = $this->getYDimensions();

        for ($i = $minX; $i <= $maxX; $i++) {
            $row = [$this->getMainAxisType() == self::DISCRETE ? "$i" : $i];
            foreach ($this->getData() as $collection) {
                /** @var SequenceData $collection */
                $row[] = isset($collection[$i]) ? $collection[$i] : null;
            }
            $rows[] = $row;
        }
        return $rows;
    }

    protected function getCols() {
        return array_merge([['type' => $this->getMainAxisType()]], parent::getCols());
    }

    public function getOptions() {
        $options = parent::getOptions();
        $series = [];

        foreach ($this->getData() as $index => $collection) {
            /** @var SequenceData $collection */
            if ($collection->getOptions()) {
                $series[$index] = $collection->getOptions();
            }
        }

        if ($series) {
            $options['series'] = $series;
        }

        $vAxes = $this->_getAxesOptions(Axis::VERTICAL);
        if ($vAxes) {
            $options['vAxes'] = $vAxes;
        }
        $hAxes = $this->_getAxesOptions(Axis::HORIZONTAL);
        if ($hAxes) {
            $options['hAxes'] = $hAxes;
        }

        return $options;
    }

    public function setMainAxisType($type) {
        $this->mainAxisType = $type;
        return $this;
    }

    public function getMainAxisType() {
        return $this->mainAxisType;
    }

    private function _getAxesOptions($dimension) {
        $axes = [];
        foreach ($this->getAxes($dimension) as $axis) {
            if ($axis->getRender()) {
                $axes[] = $axis->getOptions();
            }
        }
        return $axes;
    }

    public function addAxis(Axis $axis) {
        $this->axes[] = $axis;
        return $this;
    }

    public function getAxes($dimension = null) {
        if ($dimension) {
            $axes = [];
            foreach ($this->axes as $axis) {
                if ($axis->getDimension() == $dimension) {
                    $axes[] = $axis;
                }
            }
            return $axes;
        } else {
            return $this->axes;
        }
    }

    /**
     * @return Axis
     */
//    public function getAxis() {
//        return $this->_getAxis('x');
//    }

//    public function getXAxis() {
//        return $this->_getAxis('x');
//    }
//
//    public function getYAxis() {
//        return $this->_getAxis('y');
//    }
    
    public function getGrid() {
        return $this->getOption(['grid']);
    }
    
    public function setGrid($grid) {
        $this->setOption('grid', $grid);
    }
    
//    public function setRevertX($bool) {
//        $this->setOption('revertX', $bool);
//    }
//
//    public function getRevertX() {
//        return $this->getOption('revertX');
//    }
    
    // not implemented yet
//    public function setRevertY($bool) {
//        $this->setOption('revertY', $bool);
//    }
//
//    // not implemented yet
//    public function getRevertY() {
//        return $this->getOption('revertY');
//    }
    
//    public function getDataReductionStrategy() {
//        return $this->getOption('dataReductionStrategy');
//    }
//
//    public function setDataReductionStrategy($strategy) {
//        $this->setOption('dataReductionStrategy', $strategy);
//    }
    
    /**
     * Get first axis for specified dimension
     * 
     * @param type $position
     * @return Axis
     */
    public function getAxisByTitle($title) {
        foreach ($this->axes as $axis) {
            if ($axis->getOption('label', $title) == $title) {
                return $axis;
            }
        }
        return null;
    }
    
//
//    protected function getUrlParts() {
//        return array_merge(
//            parent::getUrlParts(),
//            array (
//                'chxt' => $this->getAxisUrlPart(), // visible axes
//                'chxr' => $this->getAxisRangeUrlPart(), // axis range
//                'chg'  => $this->getGridUrlPart(),
//            )
//        );
//    }
//

    
    /**
     * Visible axes
     * 
     * @return srting  Visible axes url part
     */
//    protected function getAxisUrlPart() {
//        $axisArray = array();
//        foreach ($this->getAxis() as $axis) {
//            if ($axis->isEnabled()) {
//                $axisArray[] = $axis->getPosition();
//            }
//        }
//        return implode(',', $axisArray);
//    }
    
    /**
     * Axis range
     * 
     * @return string
     */
    protected function getAxisRangeUrlPart() {
        //$this->calculateDimensions(); // update chart dimensions
        $scalesArray = array();
        /*$disabledAxis = */$index = 0;
        foreach ($this->getAxes() as $axis) {
            if ($axis->isEnabled() && !$axis->hasDefaultSettings()) {
                // if scale is set to 'auto' get minimal and maximal values found among all collections
                if ($axis->getMax() === Axis::AUTO || $axis->getMin() === Axis::AUTO) {
                    list($min, $max) = $axis->isVertical() ? $this->getYDimensions() : $this->getXDimensions();
                }
                
                $scalesPart = array (
                    ($axis->getMin() === Axis::AUTO ? $min : $axis->getMin()),
                    ($axis->getMax() === Axis::AUTO ? $max : $axis->getMax())
                );
                // check revert X axis
                if ($axis->isHorizontal() && $this->getRevertX()) {
                    $scalesPart = array_reverse($scalesPart);
                }
                
                $scalesArray[] = /*($index - $disabledAxis)*/ $index++ . ',' . implode(',', $scalesPart);
                
            }/* elseif (!$axis->isEnabled()) {
                // each axis has index, we need to know how many disabled axis we want to skip
                $disabledAxis++;
            }*/
        }
        if ($scalesArray) {
            return implode('|', $scalesArray);
        } else {
            return false;
        }
    }
    
    /**
     * Chart grid
     * 
     * @return string
     */
    protected function getGridUrlPart() {
        $grid = $this->getGrid();
        if ($grid->getBlocksX() === 0 && $grid->getBlocksY() === 0) {
            return false;
        } else {
            if ($grid->getBlocksX()) {
                $blocksX = $grid->getBlocksX() === 'auto' ? $this->autoGridBlocks($this->getSizeX()) : round(100 / $grid->getBlocksX(), 1);
            } else {
                $blocksX = 0;
            }
            
            if ($grid->getBlocksY()) {
                $blocksY = $grid->getBlocksY() === 'auto' ? $this->autoGridBlocks($this->getSizeY()) : round(100 / $grid->getBlocksY(), 1);
            } else {
                $blocksY = 0;
            }
            //$blocksY = $grid->getBlocksY() === 'auto' ? $this->autoGridBlocks($this->getSizeY()) : ($grid->getBlocksY() === 0 ? 0 : round(100 / $grid->getBlocksY(), 1));
            return $blocksX . ',' . $blocksY . ',' . $grid->getLineSegmentLength() . ',' . $grid->getBlankSegmentLength();
        }
        return false;
    }

    
    protected function autoGridBlocks($size) {
        if ($size <= 100) {
            return round(100 / 2, 1);
        } elseif ($size <= 200) {
            return round(100 / 3, 1);
        } elseif ($size <= 350) {
            return round(100 / 4, 1);
        } else {
            return round(100 / ($size / 100), 1);
        }
        
    }
    
    public function getYDimensions() {
        return $this->calculateAxisDimensions(Axis::VERTICAL);
    }
    
    public function getXDimensions() {
        return $this->calculateAxisDimensions(Axis::HORIZONTAL);
    }

    
    /**
     * Get minimum and maximum values among all data collections for particular axis
     */
    protected function calculateAxisDimensions($dimension) {
        $min = null;
        $max = null;
        foreach ($this->getAxes($dimension) as $axis) {
            /** @var Axis $axis */
//            if (($dimension == 'vertical' && ($axis->getPosition() == 'y' || $axis->getPosition() == 'right'))
//                || ($dimension == 'horizontal' && ($axis->getPosition() == 'x' || $axis->getPosition() == 'top'))) {

            //if ($dimension == 'vertical' && ($axis->getPosition() == 'y' || $axis->getPosition() = 'right')) {
            foreach ($this->getData() as $collection) {
                if ($axis->getOption('minValue', null) == null) {
                    $min = is_null($min) ? ($axis->isVertical() ? $collection->getMinY() : $collection->getMinX())
                                         : min(($axis->isVertical() ? $collection->getMinY() : $collection->getMinX()), $min);
                } else {
                    $min = $axis->getMin();
                }
                if ($axis->getOption('minValue', null) == null) {
                    $max = is_null($max) ? ($axis->isVertical() ? $collection->getMaxY() : $collection->getMaxX())
                                         :  max(($axis->isVertical() ? $collection->getMaxY() : $collection->getMaxX()), $max);
                } else {
                    $max = $axis->getMax();
                }
            }
        }
        
        return array($min, $max);
    }
    
//    protected function prepareData() {
//        $dimensions = $this->getXDimensions('x');
//        $scale = floor(($dimensions['max'] - $dimensions['min']) / $this->getSizeX());
//        $retCollection = array();
//
//        if ($scale > 2 && $this->getDataReductionStrategy() != self::STRATEGY_NONE) {
//            foreach ($this->getData() as $collection) {
////                $reducedCollection = new SequenceData();
//                $chunkIndex = $dimensions['min'];
//                $chunkArray = array();
//                $totalChunks = ceil(($dimensions['max'] - $dimensions['min']) / $scale);
//
//                for ($i=0; $i < $totalChunks; $i++) {
//                    for ($j=$i * $totalChunks; $j < $scale; $j++) {
//                        if ($this->getDataReductionStrategy() == self::STRATEGY_MAX) {
//
//                        }
//                    }
//                }
//                $retCollection[] = $reducedCollection;
//            }
//        } else {
//            return $this->getData();
//        }
//    }
    
    /**
     * @return boolean  True if it's necessary to print this axis
     */
    /*protected function hasToPrint(Axis $axis) {
        return $axis->isEnabled() && !$axis->hasDefaultSettings();
    }*/


}

