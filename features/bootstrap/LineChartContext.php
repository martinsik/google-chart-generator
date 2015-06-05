<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Mock\DummyChart;
use GoogleChartGenerator\Chart\LineChart;

include_once 'RenderHTMLTemplateMixin.php';

/**
 * Features context.
 */
class LineChartContext extends BehatContext {

    use RenderHTMLTemplateMixin;


    private $charts = [];
    private $expectedChart = [];


    /**
     * @Given /^a set of test data to create multiple line charts$/
     */
    public function aSetOfTestDataToCreateMultipleLineCharts()
    {
        $chart = new LineChart(['title' => 'Test Chart #1']);
        $chart->addData(new LineChart\Line([12, 24, 20, 18, 16], ['label' => 'Line #1']));
        $chart->addData(new LineChart\Line([31, 27, 31, 28, 30], ['label' => 'Line #2']));
        $this->charts[] = $chart;

        $this->expectedChart[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"title":"Test Chart #1"}'
    cols='[{"type":"number"},{"type":"number","label":"Line #1"},{"type":"number","label":"Line #2"}]'
    rows='[[0,12,31],[1,24,27],[2,20,31],[3,18,28],[4,16,30]]'>
</google-chart>
EXPECTED;


        $chart = new LineChart(['height' => 200, 'width' => 300]);
        $line = new LineChart\Line([15, 32, 52, 48]);
        $chart->addData($line);
        $seriesOptions = ['color' => '#005500', 'lineDashStyle' => [5, 2], 'pointSize' => 3, 'lineWidth' => 1];
        $chart->addData(new LineChart\Line([2 => 14, 3 => 19, 4 => 12, 5 => 17, 6 => 13], null, $seriesOptions));
        $chart->addData(new LineChart\Line([0 => 42, 1 => 40, 2 => 36, 4 => 45, 5 => 42, 6 => 48], null, ['color' => 'black', 'lineWidth' => 4]));
        $chart->getAxisByTitle('y')->setMin(0);
        $this->charts[] = $chart;

        $this->expectedChart[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"height":200,"width":300,"series":{"1":{"color":"#005500","lineDashStyle":[5,2],"pointSize":3,"lineWidth":1},"2":{"color":"black","lineWidth":4}}}'
    cols='[{"type":"number"},{"type":"number"},{"type":"number"},{"type":"number"}]'
    rows='[[0,15,null,42],[1,32,null,40],[2,52,14,36],[3,48,19,null],[4,null,12,45],[5,null,17,42],[6,null,13,48]]'>
</google-chart>
EXPECTED;


        $chart = new LineChart();
        $chart->getAxisByTitle('x');

        $chart->addData(new LineChart\Line([1020, 2040, 2000, 1800, 1060], ['label' => 'Line #1']));
        $chart->addData(new LineChart\Line([-310, 270, 301, 208, 300], ['label' => 'Line #2']));
        $this->charts[] = $chart;

        $this->expectedChart[] = <<<EXPECTED
<google-chart
    type='line'
    options='[]'
    cols='[{"type":"number"},{"type":"number","label":"Line #1"},{"type":"number","label":"Line #2"}]'
    rows='[[0,1020,-310],[1,2040,270],[2,2000,301],[3,1800,208],[4,1060,300]]'>
</google-chart>
EXPECTED;
    }

    /**
     * @Then /^compare line charts with expected values$/
     */
    public function compareLineChartsWithExpectedValues()
    {
        foreach ($this->charts as $index => $chart) {
            /** @var $chart LineChart */
            if (isset($this->expectedChart[$index])) {
                assertEquals($this->expectedChart[$index], $chart->getElement());
            } else {
                var_dump($chart->getElement());
            }
        }

    }

    /**
     * @Given /^manually check their results with expected HTML templates in "([^"]*)" as "([^"]*)"$/
     */
    public function manuallyCheckTheirResultsWithExpectedHtmlTemplatesInAs($dir, $filename)
    {
//        $expectHTML = [];
        $actualHTML = [];
        foreach ($this->charts as $index => $chart) {
            /** @var $chart LineChart */
            $actualHTML[] = $chart->getElement();
        }

        $this->render($dir, $filename, $actualHTML);

    }

}