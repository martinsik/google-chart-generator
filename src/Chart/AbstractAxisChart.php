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

        $this->addAxis(new Axis(Axis::VERTICAL, ['title' => 'y']));
        $this->addAxis(new Axis(Axis::HORIZONTAL, ['title' => 'x']));
    }

    protected function getRows() {
        $rows = [];

        list($minX, $maxX) = $this->getXDimensions();
//        list($minY, $maxY) = $this->getYDimensions();

        if ($this->getMainAxisType() == self::DISCRETE) {
            for ($i = $minX; $i <= $maxX; $i++) {
                $rows[] = $this->getSingleRow($i);
            }
        } else {
            $data = $this->getData()[0];
            foreach (array_keys($data->getData()) as $key) {
                $rows[] = $this->getSingleRow($key);
            }
        }
        return $rows;
    }

    private function getSingleRow($i) {
        $row = [$this->getMainAxisType() == self::DISCRETE ? "$i" : $i];
        foreach ($this->getData() as $collection) {
            /** @var SequenceData $collection */
            $row[] = isset($collection[$i]) ? $collection[$i] : null;
        }
        return $row;
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

    public function getGrid() {
        return $this->getOption(['grid']);
    }
    
    public function setGrid($grid) {
        $this->setOption('grid', $grid);
    }
    
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

}

