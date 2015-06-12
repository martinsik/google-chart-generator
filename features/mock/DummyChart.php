<?php

namespace GoogleChartGenerator\Mock;

use GoogleChartGenerator\Chart\AbstractChart;


class DummyChart extends AbstractChart {

    function getChartName() {
        return 'dummy';
    }

}