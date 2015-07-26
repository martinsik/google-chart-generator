<?php

namespace GoogleChartGenerator\Chart;

use GoogleChartGenerator\Chart\AbstractAxisChart;
//use GoogleChartGenerator\Axis;

class ColumnChart extends AbstractAxisChart {

    protected function getChartName() {
        return 'column';
    }

}

