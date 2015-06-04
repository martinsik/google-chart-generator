<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Mock\DummyChart;
use GoogleChartGenerator\Chart\LineChart;

/**
 * Features context.
 */
class LineChartContext extends BehatContext {

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


        $chart = new LineChart(['colors' => ['#00ff00', '#444', '#ff00ff']]);
        $line = new LineChart\Line([15, 32, 52, 48]);
        $chart->addData($line);
        $chart->addData(new LineChart\Line([2 => 14, 3 => 19, 4 => 12, 5 => 17, 6 => 13]));
        $chart->addData(new LineChart\Line([0 => 42, 1 => 40, 2 => 36, 4 => 45, 5 => 42, 6 => 48]));
        $chart->getAxis('y')->setMin(0);
        $this->charts[] = $chart;

        $this->expectedChart[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"colors":["#00ff00","#444","#ff00ff"]}'
    cols='[{"type":"number"},{"type":"number"},{"type":"number"},{"type":"number"}]'
    rows='[[0,15,null,42],[1,32,null,40],[2,52,14,36],[3,48,19,null],[4,null,12,45],[5,null,17,42],[6,null,13,48]]'>
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
            assertEquals($this->expectedChart[$index], $chart->getElement());
        }

    }

    /**
     * @Given /^manually check their results with expected HTML templates in "([^"]*)" as "([^"]*)"$/
     */
    public function manuallyCheckTheirResultsWithExpectedHtmlTemplatesInAs($dir, $filename)
    {
        $dir = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/../' . DIRECTORY_SEPARATOR . $dir);
        @mkdir($dir);
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        @unlink($filepath);

//        $expectHTML = [];
        $actualHTML = [];
        foreach ($this->charts as $index => $chart) {
            $actualHTML[] = $chart->getElement();
        }

        $html = file_get_contents($dir . DIRECTORY_SEPARATOR . '_template.html');
        $html = str_replace(['__EXPECTED__', '__ACTUAL__'], [implode('', $this->expectedChart), implode('', $actualHTML)], $html);
        file_put_contents($filepath, $html);
    }

}