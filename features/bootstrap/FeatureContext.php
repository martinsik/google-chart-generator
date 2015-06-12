<?php

use Behat\Behat\Context\BehatContext;



class FeatureContext extends BehatContext {

    public function __construct(array $parameters) {
        $this->useContext('options_subcontext_alias', new OptionsContext());
        $this->useContext('data_collection_subcontext_alias', new DataCollectionContext());
        $this->useContext('axis_chart_subcontext_alias', new AxisChartContext());
        $this->useContext('line_chart_subcontext_alias', new LineChartContext());
        $this->useContext('pie_chart_subcontext_alias', new PieChartContext());
        $this->useContext('common_chart_subcontext_alias', new CommonChartContext());
    }

}