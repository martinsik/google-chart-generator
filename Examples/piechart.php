<?php

include_once '../loader.php';

use GoogleChartGenerator\Library\PieChart\PieChart;
use GoogleChartGenerator\Library\PieChart\Arc;

$charts = array();

$chart = new PieChart(array('title' => 'Default settings'));
$chart->addData(new Arc(40));
$chart->addData(new Arc(60));
$chart->addData(new Arc(30));
$charts[] = $chart;

$chart = new PieChart();
$chart->addData(array(new Arc(40), new Arc(60, array('color' => 'BBBBBB')), new Arc(30)));
$chart->setOrientation(0.5);
$charts[] = $chart;

$chart = new PieChart(array('legend' => true));
$chart->addData(new Arc(rand(1,30), array('title' => 'Arc #1')));
$chart->addData(new Arc(rand(1,30), array('title' => 'Arc #2')));
$chart->addData(new Arc(rand(1,30), array('title' => 'Arc #3')));
$chart->addData(new Arc(rand(1,30), array('title' => 'Arc #4')));
$charts[] = $chart;

$chart = new PieChart(array('legend' => true, '3d' => true));
for ($i=1; $i < 5; $i++) {
    $chart->addData(new Arc(rand(1,30), array('title' => 'Arc #' . $i)));
}
$charts[] = $chart;

include 'view.php';
