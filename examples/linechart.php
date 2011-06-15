<?php

require_once __DIR__ . '/loader.php';

use GoogleChartGenerator\Chart\LineChart\LineChart;
use GoogleChartGenerator\Chart\LineChart\Line;

function getRandomData($size, $min = 0, $max = 100) {
    $values = $keys = array();
    for ($i=0; $i < $size; $i++) {
        $values[] = rand($min, $max);
        $keys[] = $i;
    }
    return array_combine($keys, $values);
}

$charts = array();

// default settings
$chart = new LineChart(array('title' => 'Default settings'));
$chart->addLine(new Line(getRandomData(20)));
$charts[] = $chart;

// size, y axis
$chart = new LineChart(array('title' => 'Size, y axis'));
$chart->setSize('500x200');
$chart->getYAxis()->setMax(150)->setMin(-50);
$line = new Line(array(72.932,74.812,74.436,78.195,66.917,73.308,68.045,66.165,64.286,77.068,65.789,57.895,67.669,64.286,71.429,81.579,85.338,64.662,67.293,75.188,60.902,66.917,74.812,85.338,72.932,73.308,72.556,75.564,75.564,74.812,77.82,78.947,77.444));
$chart->addLine($line);
$charts[] = $chart;

// size, more lines, colours, widths
$chart = new LineChart(array('title' => 'Size, more lines, colors, widths'));
$chart->setSize('800x200');
$chart->getYAxis()->setMax(100);
$chart->setLegend('b');
$line = new Line(getRandomData(20, 40, 60), array('title' => 'Line #1'));
$line->setWidth(4);
$line2 = new Line(getRandomData(20, 20, 80), array('title' => 'Line #2'));
$line2->setWidth(3);
$line3 = new Line(getRandomData(20, 20, 80), array('title' => 'Line #3'));
$line3->setWidth(2);
$line4 = new Line(getRandomData(20), array('title' => 'grey line'));
$line4->setColour('eeeeee');
$chart->addLine($line4);
$chart->addLine($line);
$chart->addLine($line2);
$chart->addLine($line3);
try {
    $dir = __DIR__ . '/cache';
    if (!is_dir($dir)) {
        mkdir($dir);
    }
    $chart->download($dir . '/' . time() . '.png');
} catch (Exception $e) { }
$charts[] = $chart;

// custom x values
$chart = new LineChart(array('legend' => true));
$chart->addLine(new Line(getRandomData(10, 10, 60), array('title' => 'Line #1')));
$chart->addLine(new Line(array(4 => 50, 5 => 30, 7 => 30, 8 => 45), array('title' => 'Line #2')));
$chart->addLine(new Line(array(2 => 50, 3 => 30, 4 => 35, 5 => 45, 6 => 20), array('title' => 'Line #3')));
$chart->getXAxis()->setMin(0)->setMax(10);
$chart->getYAxis()->setMin(10)->setMax(60);
$charts[] = $chart;

// sparkline #1
$chart = new LineChart();
$chart->setTitle(null);
$chart->setSize('180x120');
$chart->setSparkline(true);
$chart->addLine(new Line(array(5,6,14,8,11,3,2,29,35,26,40,29,51,60,57,6,2,1), array('color' => '000088')));
$charts[] = $chart;

// sparkline #2
$chart = new LineChart(array('title' => null, 'size' => '180x120', 'sparkline' => true));
$chart->addLine(new Line(array(5,6,14,8,11,3,2,29,35,26,40,29,51,60,57,6,2,1), array('color' => '880000')));
$charts[] = $chart;

// legend position
$chart = new LineChart(array('title' => null, 'size' => '180x120', 'legend' => 'b'));
$chart->addLine(new Line(array(2 => 50, 3 => 30, 4 => 35, 5 => 45, 6 => 20), array('title' => 'hello!')));
$charts[] = $chart;

$chart = new LineChart(array('title' => null, 'size' => '180x120'/*, 'legend' => 'b'*/));
$chart->getXAxis()->setEnabled(false);
$chart->getYAxis()->setEnabled(false);
$chart->addLine(new Line(array(5,24,18,8,11,27,26,29,35,20), array('width' => 3, 'title' => 'blue', 'color' => '0070C0')));
$chart->addLine(new Line(array(8,11,25,2,29,35,8,40,29,23), array('width' => 3, 'title' => 'orange', 'color' => 'F07200')));
$charts[] = $chart;

$chart = new LineChart(array('title' => null, 'size' => '180x120'/*, 'legend' => 'b'*/));
$chart->getXAxis()->setEnabled(false);
$chart->getYAxis()->setEnabled(false);
$chart->addLine(new Line(array(8,11,25,2,29,35,8,40,29,23), array('width' => 3, 'title' => 'orange', 'color' => 'F07200')));
$chart->addLine(new Line(array(5,24,18,8,11,27,26,29,35,20), array('width' => 3, 'title' => 'blue', 'color' => '0070C0')));
$charts[] = $chart;

// data plain text encoding
$chart = new LineChart(array('title' => 'Plain text encoding'));
$chart->addLine(new Line(getRandomData(20)));
$charts[] = $chart;

include 'view.php';
