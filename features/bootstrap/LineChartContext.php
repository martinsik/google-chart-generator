<?php

use Behat\Behat\Context\BehatContext;
use GoogleChartGenerator\Chart\LineChart;
use GoogleChartGenerator\Axis;

require_once 'HTMLRenderableTrait.php';

/**
 * Features context.
 */
class LineChartContext extends AbstractChartContext {

    use HTMLRenderableTrait;

    /**
     * @Given /^a set of test data to create multiple line charts$/
     */
    public function aSetOfTestDataToCreateMultipleLineCharts()
    {
        $chart = new LineChart(['title' => 'Test Chart #1']);
        $chart->addData(new LineChart\Line([12, 24, 20, 18, 16], ['label' => 'Line #1']));
        $chart->addData(new LineChart\Line([31, 27, 31, 28, 30], ['label' => 'Line #2']));
        $this->charts[] = $chart;

        $this->expected[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"title":"Test Chart #1"}'
    cols='[{"type":"string"},{"type":"number","label":"Line #1"},{"type":"number","label":"Line #2"}]'
    rows='[["0",12,31],["1",24,27],["2",20,31],["3",18,28],["4",16,30]]'>
</google-chart>
EXPECTED;


        $chart = new LineChart(['height' => 200, 'width' => 300]);
        $line = new LineChart\Line([15, 32, 52, 48]);
        $chart->addData($line);
        $options = ['color' => '#005500', 'lineDashStyle' => [5, 2], 'pointSize' => 3, 'lineWidth' => 1];
        $chart->addData(new LineChart\Line([2 => 14, 3 => 19, 4 => 12, 5 => 17, 6 => 13], $options));
        $chart->addData(new LineChart\Line([0 => 42, 1 => 40, 2 => 36, 4 => 45, 5 => 42, 6 => 48], ['color' => 'black', 'lineWidth' => 4]));
//        $chart->getAxisByTitle('y')->setMin(0);
        $this->charts[] = $chart;

        $this->expected[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"height":200,"width":300,"series":{"1":{"color":"#005500","lineDashStyle":[5,2],"pointSize":3,"lineWidth":1},"2":{"color":"black","lineWidth":4}}}'
    cols='[{"type":"string"},{"type":"number"},{"type":"number"},{"type":"number"}]'
    rows='[["0",15,null,42],["1",32,null,40],["2",52,14,36],["3",48,19,null],["4",null,12,45],["5",null,17,42],["6",null,13,48]]'>
</google-chart>
EXPECTED;


        $chart = new LineChart();
        $chart->setMainAxisType(LineChart::CONTINUOUS);
        $hAxis = $chart->getAxes(Axis::HORIZONTAL)[0];
        $hAxis->setOption('title', 'some title');
        $hAxis->setOption('gridlines', ['count' => 3]);
        $vAxis = $chart->getAxes(Axis::VERTICAL)[0];
        $vAxis->setOption('format', 'short');
        $vAxis->setOption('title', null);

        $chart->addData(new LineChart\Line([1020, 2040, 2000, 1800, 1060], ['label' => 'Line #1']));
        $chart->addData(new LineChart\Line([-310, 270, 301, 208, 300], ['label' => 'Line #2']));
        $this->charts[] = $chart;

        $this->expected[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"vAxes":[{"title":null,"format":"short"}],"hAxes":[{"title":"some title","gridlines":{"count":3}}]}'
    cols='[{"type":"number"},{"type":"number","label":"Line #1"},{"type":"number","label":"Line #2"}]'
    rows='[[0,1020,-310],[1,2040,270],[2,2000,301],[3,1800,208],[4,1060,300]]'>
</google-chart>
EXPECTED;


        $chart = new LineChart(['title' => 'Test Continuous Chart']);
        $chart->setMainAxisType(LineChart::CONTINUOUS);
        $chart->addData(new LineChart\Line([
            2 => 42,
            5 => 38,
            70 => 45,
            80 => 44,
            100 => 41
        ]));
        $chart->addData(new LineChart\Line([
            2 => 22,
            5 => 24,
            70 => 18,
            80 => 20,
            100 => 17
        ]));
        $this->charts[] = $chart;

        $this->expected[] = <<<EXPECTED
<google-chart
    type='line'
    options='{"title":"Test Continuous Chart"}'
    cols='[{"type":"number"},{"type":"number"},{"type":"number"}]'
    rows='[[2,42,22],[5,38,24],[70,45,18],[80,44,20],[100,41,17]]'>
</google-chart>
EXPECTED;
    }

}