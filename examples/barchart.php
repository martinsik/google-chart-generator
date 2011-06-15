<?php

require_once __DIR__ . '/loader.php';

use GoogleChartGenerator\Chart\BarChart\BarChart;
use GoogleChartGenerator\Chart\BarChart\Bar;


function getRandomData($size, $min = 0, $max = 100) {
    $values = $keys = array();
    for ($i=0; $i < $size; $i++) {
        $values[] = rand($min, $max);
        $keys[] = $i;
    }
    return array_combine($keys, $values);
}

$charts = array();

$chart = new BarChart(array('title' => 'Default settings'));
$chart->addData(new Bar(getRandomData(6)));
$charts[] = $chart;

$chart = new BarChart(array('size' => '620x200', 'legend' => true));
$chart->addData(new Bar(getRandomData(6), array('title' => 'Bar #1')));
$chart->addData(new Bar(getRandomData(6), array('title' => 'Bar #2')));
$chart->addData(new Bar(getRandomData(6), array('title' => 'Bar #3')));
$charts[] = $chart;

$chart = new BarChart(array('stacked' => true));
$chart->addData(new Bar(getRandomData(6)));
$chart->addData(new Bar(getRandomData(6)));
$charts[] = $chart;

$chart = new BarChart(array('position' => 'horizontal', 'size' => '300x230'));
$chart->addData(new Bar(getRandomData(6)));
$charts[] = $chart;

$chart = new BarChart(array('position' => 'horizontal', 'size' => '300x210'));
$chart->addData(new Bar(getRandomData(3)));
$chart->addData(new Bar(getRandomData(3)));
//$chart->addData(new Bar(getRandomData(6)));
$charts[] = $chart;

$chart = new BarChart(array('position' => 'horizontal', 'size' => '300x210'));
$chart->setStacked(true);
$chart->addData(new Bar(getRandomData(6)));
$chart->addData(new Bar(getRandomData(6)));
$chart->addData(new Bar(getRandomData(6)));
$charts[] = $chart;

include 'view.php';
