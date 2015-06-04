<?php

namespace GoogleChartGenerator\Mock;

use GoogleChartGenerator\DataCollection\SequenceData;

class DummySequentialDataCollection extends SequenceData {

    public function getType() {
        return 'dummy';
    }

}