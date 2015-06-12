<?php

namespace GoogleChartGenerator\Chart\PieChart;

use GoogleChartGenerator\DataCollection\SingleData;

class Arc extends SingleData {
    
    public function __construct($value, $label = null, $options = []) {
        parent::__construct($options);

        $this->data = [$label, $value];
    }


}
