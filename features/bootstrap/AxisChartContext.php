<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Mock\DummyAxisChart;
use GoogleChartGenerator\Mock\DummySequentialDataCollection;


class AxisChartContext extends BehatContext {

    private $charts = [];
    private $expectedRange = [];
    private $expectedRows = [];
    private $expectedAxis = [];

    /**
     * @Given /^charts with multiple data sets each with different ranges$/
     */
    public function chartsWithMultipleDataSetsEachWithDifferentRanges()
    {
        $chart = new DummyAxisChart();
        $chart->addData(new DummySequentialDataCollection([23, 18, 24, 26, 22]));
        $chart->addData(new DummySequentialDataCollection([31, 42, 34, 31, 36]));
        $chart->addData(new DummySequentialDataCollection([7,   9,  4,  2,  3]));
        $this->charts[] = $chart;
        $this->expectedRangeX[] = [0, 4];
        $this->expectedRangeY[] = [2, 42];
        $this->expectedRows[] = [
            [23, 31, 7],
            [18, 42, 9],
            [24, 34, 4],
            [26, 31, 2],
            [22, 36, 3],
        ];

        // with missing values
        $chart = new DummyAxisChart();
        $chart->addData(new DummySequentialDataCollection([15, 32, 52]));
        $chart->addData(new DummySequentialDataCollection([2 => 14, 3 => 19, 4 => 12, 6 => 13]));
        $chart->addData(new DummySequentialDataCollection([0 => 42, 1 => 40, 4 => 45]));
        $chart->getAxis('y')->setMin(0);
        $this->charts[] = $chart;
        $this->expectedRangeX[] = [0, 6];
        $this->expectedRangeY[] = [0, 52];
        $this->expectedRows[] = [
            [15,   null, 42],
            [32,   null, 40],
            [52,   14,   null],
            [null, 19,   null],
            [null, 12,   45],
            [null, null, null],
            [null, 13,   null],
        ];
    }

    /**
     * @Then /^check their ranges cover all data sets$/
     */
    public function checkTheirRangesCoverAllDataSets()
    {
        foreach ($this->charts as $index => $chart) {
            /** @var DummyAxisChart $chart */
            assertEquals($this->expectedRangeX[$index], $chart->getXDimensions());
            assertEquals($this->expectedRangeY[$index], $chart->getYDimensions());
        }
    }

    /**
     * @Given /^prepared rows cover entire range with missing values filled$/
     */
    public function preparedRowsCoverEntireRangeWithMissingValuesFilled()
    {
        $method = new ReflectionMethod('GoogleChartGenerator\Mock\DummyAxisChart', 'getRows');
        $method->setAccessible(true);
        foreach ($this->charts as $index => $chart) {
            /** @var DummyAxisChart $chart */
            $result = $method->invoke($chart);
//            print_r($result);
            assertEquals($this->expectedRows[$index], $result);
        }

    }

    /**
     * @Then /^default axes aren\'t rendered at all$/
     */
    public function defaultAxesArenTRenderedAtAll()
    {

    }

}