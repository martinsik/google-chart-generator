<?php

namespace GoogleChartGenerator\Mock;

use GoogleChartGenerator\Chart\AbstractAxisChart;


class DummyAxisChart extends AbstractAxisChart {

    public function getChartName() {
        return 'dummy';
    }

}