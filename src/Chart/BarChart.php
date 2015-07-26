<?php

namespace GoogleChartGenerator\Chart;

use GoogleChartGenerator\Chart\AbstractAxisChart;
use GoogleChartGenerator\Axis;

class BarChart extends AbstractAxisChart {

    protected function getChartName() {
        return 'bar';
    }

}

