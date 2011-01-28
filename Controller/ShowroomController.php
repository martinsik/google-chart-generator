<?php

namespace Bundle\GoogleChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\GoogleChartBundle\Library\LineChart\LineChart;
use Bundle\GoogleChartBundle\Library\LineChart\Line;

class ShowroomController extends Controller {
    
    public function lineChartAction() {
        $charts = array();
        
        // default settings
        $chart = new LineChart(array('title' => 'Default settings'));
        $line = new Line();
        $line->add($this->getRandomData(20));
        $chart->addLine($line);
        $charts[] = $chart;
        
        // size, y axis
        $chart = new LineChart(array('title' => 'Size, y axis'));
        $chart->setSize('500x200');
        $chart->getYAxis()->setMax(150)->setMin(-50);
        $line = new Line();
        $line->add(array(72.932,74.812,74.436,78.195,66.917,73.308,68.045,66.165,64.286,77.068,65.789,57.895,67.669,64.286,71.429,81.579,85.338,64.662,67.293,75.188,60.902,66.917,74.812,85.338,72.932,73.308,72.556,75.564,75.564,74.812,77.82,78.947,77.444));
        $chart->addLine($line);
        $charts[] = $chart;
        
        // size, more lines, colours, widths
        $chart = new LineChart(array('title' => 'Size, more lines, colors, widths'));
        $chart->setSize('600x300');
        $chart->getYAxis()->setMax(100);
        
        $line = new Line();
        $line->add($this->getRandomData(20, 40, 60));
        $line->setWidth(4);
        //$line->setColour('555555');
        $line2 = new Line();
        $line2->add($this->getRandomData(20, 20, 80));
        $line2->setWidth(3);
        $line3 = new Line();
        $line3->add($this->getRandomData(20, 20, 80));
        $line3->setWidth(2);
        $line4 = new Line();
        $line4->add($this->getRandomData(30));
        $line4->setColour('eeeeee');
        
        $chart->addLine($line4);
        $chart->addLine($line);
        $chart->addLine($line2);
        $chart->addLine($line3);
        $charts[] = $chart;
        
        return $this->render('GoogleChartBundle:Showroom:charts.twig', array('charts' => $charts));
    }
    
    protected function getRandomData($size, $min = 0, $max = 100) {
        $values = $keys = array();
        for ($i=0; $i < $size; $i++) {
            $values[] = rand($min, $max);
            $keys[] = $i;
        }
        return array_combine($keys, $values);
    }
    
}
