<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Axis;
use GoogleChartGenerator\Mock\DummyAxisChart;
use GoogleChartGenerator\Mock\DummySequentialDataCollection;


class AxisChartContext extends BehatContext {

    private $charts = [];
    private $expectedRangeX = [];
    private $expectedRows = [];
//    private $expectedAxis = [];

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
//        $this->expectedRangeY[] = [2, 42];
        $this->expectedRows[] = [
            [0, 23, 31, 7],
            [1, 18, 42, 9],
            [2, 24, 34, 4],
            [3, 26, 31, 2],
            [4, 22, 36, 3],
        ];

        // with missing values
        $chart = new DummyAxisChart();
        $chart->addData(new DummySequentialDataCollection([15, 32, 52]));
        $chart->addData(new DummySequentialDataCollection([2 => 14, 3 => 19, 4 => 12, 6 => 13]));
        $chart->addData(new DummySequentialDataCollection([0 => 42, 1 => 40, 4 => 45]));
//        $chart->getAxes(Axis::VERTICAL)[0]->setMin(0);
        $this->charts[] = $chart;
        $this->expectedRangeX[] = [0, 6];
//        $this->expectedRangeY[] = [0, 52];
        $this->expectedRows[] = [
            [0, 15,   null, 42],
            [1, 32,   null, 40],
            [2, 52,   14,   null],
            [3, null, 19,   null],
            [4, null, 12,   45],
            [5, null, null, null],
            [6, null, 13,   null],
        ];

        // with continuous main axis
        $chart = new DummyAxisChart();
        $chart->addData(new DummySequentialDataCollection([
            2 => 42,
            3 => 38,
            7 => 45,
            8 => 44,
            10 => 41
        ]));
        $chart->addData(new DummySequentialDataCollection([
            2 => 22,
            3 => 24,
            7 => 18,
            8 => 20,
            10 => 17
        ]));
        $chart->setMainAxisType(\GoogleChartGenerator\Chart\AbstractAxisChart::CONTINUOUS);
        $this->charts[] = $chart;
        $this->expectedRangeX[] = [2, 10];
        $this->expectedRows[] = [
            [2,  42, 22],
            [3,  38, 24],
            [7,  45, 18],
            [8,  44, 20],
            [10, 41, 17]
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
//            assertEquals($this->expectedRangeY[$index], $chart->getYDimensions());
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