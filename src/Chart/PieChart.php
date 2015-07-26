<?php

namespace GoogleChartGenerator\Chart;

use GoogleChartGenerator\Chart\AbstractChart;
use GoogleChartGenerator\Chart\PieChart\Arc;
use GoogleChartGenerator\DataCollection\SingleData;


class PieChart extends AbstractChart {

    public function addData($data) {
        if (is_array($data)) {
            foreach ($data as $arc) {
                parent::addData($arc instanceof SingleData ? $arc : new SingleData($arc));
            }
        } else {
            parent::addData($data);
        }
    }

    public function getRows() {
        $rows = [];
        foreach ($this->data as $arc) {
            $rows[] = $arc->getData();
        }
        return $rows;
    }

    protected function getCols() {
        return [['type' => 'string', 'label' => 'Title'], ['type' => 'number', 'label' => 'Value']];
    }

    protected function getChartName() {
        return 'pie';
    }
    
}
