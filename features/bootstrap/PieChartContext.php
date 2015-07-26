<?php

use Behat\Behat\Context\BehatContext;
use GoogleChartGenerator\Chart\PieChart;
use GoogleChartGenerator\DataCollection\SingleData;
use GoogleChartGenerator\Axis;

require_once 'HTMLRenderableTrait.php';

/**
 * Features context.
 */
class PieChartContext extends AbstractChartContext
{

    use HTMLRenderableTrait;

    /**
     * @Given /^a set of test data to create multiple pie charts$/
     */
    public function aSetOfTestDataToCreateMultiplePieCharts()
    {
        $chart = new PieChart(['legend' => 'none']);
        $chart->addData([20, 40, 30]);
        $chart->addData(new SingleData(10));
        $this->charts[] = $chart;
        $this->expected[] = <<<EXPECTED
<google-chart style=""
    type='pie'
    options='{"legend":"none"}'
    cols='[{"type":"string","label":"Title"},{"type":"number","label":"Value"}]'
    rows='[[null,20],[null,40],[null,30],[null,10]]'>
</google-chart>
EXPECTED;


        $chart = new PieChart(['width' => '150px', 'height' => '150px', 'pieHole' => 0.5]);
        $chart->addData([new SingleData(40, 'Arc #1'), new SingleData(60, 'Arc #2'), new SingleData(80, 'Arc #3')]);
        $this->charts[] = $chart;
        $this->expected[] = <<<EXPECTED
<google-chart style="width:150px;height:150px;"
    type='pie'
    options='{"pieHole":0.5}'
    cols='[{"type":"string","label":"Title"},{"type":"number","label":"Value"}]'
    rows='[["Arc #1",40],["Arc #2",60],["Arc #3",80]]'>
</google-chart>
EXPECTED;


        $chart = new PieChart(['is3D' => true, 'title' => '3D Pie Chart', 'width' => '500px', 'height' => '400px']);
        $chart->addData([new SingleData(40, 'Arc #1'), new SingleData(60, 'Arc #2'), new SingleData(80, 'Arc #3')]);
        $this->charts[] = $chart;
        $this->expected[] = <<<EXPECTED
<google-chart style="width:500px;height:400px;"
    type='pie'
    options='{"is3D":true,"title":"3D Pie Chart"}'
    cols='[{"type":"string","label":"Title"},{"type":"number","label":"Value"}]'
    rows='[["Arc #1",40],["Arc #2",60],["Arc #3",80]]'>
</google-chart>
EXPECTED;
    }

    /**
     * @Then /^compare pie charts with expected values and manually check their results with expected HTML templates in "([^"]*)" as "([^"]*)"$/
     */
    public function comparePieChartsWithExpectedValuesAndManuallyCheckTheirResultsWithExpectedHtmlTemplatesInAs($dir, $filename)
    {
        $this->compareChartsWithExpectedValues();
        $this->manuallyCheckTheirResultsWithExpectedHtmlTemplatesInAs($dir, $filename);
    }

}