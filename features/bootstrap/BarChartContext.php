<?php

use GoogleChartGenerator\Chart\BarChart;
use GoogleChartGenerator\DataCollection\SequenceData;
use GoogleChartGenerator\Axis;

require_once 'HTMLRenderableTrait.php';


class BarChartContext extends AbstractChartContext {

    use HTMLRenderableTrait;

    /**
     * @Given /^a set of test data to create multiple bar charts$/
     */
    public function aSetOfTestDataToCreateMultipleBarCharts()
    {
        $chart = new BarChart();
        $chart->addData(new SequenceData([20, 40, 30]));
//        $chart->addData(new Bar(10, 'Bar #4'));
        $this->charts[] = $chart;
        $this->expected[] = <<<EXPECTED
<google-chart style=""
    type='bar'
    options='[]'
    cols='[{"type":"string"},{"type":"number"}]'
    rows='[["0",20],["1",40],["2",30]]'>
</google-chart>
EXPECTED;

        $chart = new BarChart(['width' => '700px', 'isStacked' => true, 'legend' => ['position' => 'none']]);
        $chart->addData(new SequenceData(["a1" => 20, "a2" => 40, "a3" => 30], ['label' => 'aaa']));
        $chart->addData(new SequenceData(["a1" => 15, "a2" => 32, "a3" => 34], ['label' => 'bbb']));
        $chart->addData(new SequenceData(["a1" => 21, "a2" => 42, "a3" => 17], ['label' => 'ccc']));
        $this->charts[] = $chart;
        $this->expected[] = <<<EXPECTED
<google-chart style="width:700px;"
    type='bar'
    options='{"isStacked":true,"legend":{"position":"none"}}'
    cols='[{"type":"string"},{"type":"number","label":"aaa"},{"type":"number","label":"bbb"},{"type":"number","label":"ccc"}]'
    rows='[["a1",20,15,21],["a2",40,32,42],["a3",30,34,17]]'>
</google-chart>
EXPECTED;

    }

    /**
     * @Then /^compare bar charts with expected values and manually check their results with expected HTML templates in "([^"]*)" as "([^"]*)"$/
     */
    public function compareBarChartsWithExpectedValuesAndManuallyCheckTheirResultsWithExpectedHtmlTemplatesInAs($dir, $filename)
    {
        $this->compareChartsWithExpectedValues();
        $this->manuallyCheckTheirResultsWithExpectedHtmlTemplatesInAs($dir, $filename);
    }

}
