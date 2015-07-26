<?php

namespace GoogleChartGenerator\DataCollection;

use GoogleChartGenerator\DataCollection\AbstractData;

class SingleData extends AbstractData {

    public function __construct($value, $label = null, $options = []) {
        parent::__construct($options);

        $this->data = [$label, $value];
    }

}
