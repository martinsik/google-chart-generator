<?php

namespace GoogleChartGenerator\Mock;

use GoogleChartGenerator\DataCollection\AbstractData;


class DummyDataCollection extends AbstractData {

    public function getType() {
        return 'dummy';
    }

}