<?php

namespace Bundle\GoogleChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\GoogleChartBundle\Library\LineChart\LineChart;
use Bundle\GoogleChartBundle\Library\LineChart\Line;

class ShowroomController extends Controller {
    
    public function lineChartAction() {
        $charts = array();
        
        $chart = new LineChart();
        $chart->setTitle('Default configuration');
        $line = new Line();
        $line->add($this->getRandomData(20));
        $chart->addData($line);
        $charts[] = $chart;
        
        $chart = new LineChart();
        $chart->setSize('400x200');
        $line = new Line();
        $line->add($this->getRandomData(10));
        $chart->addData($line);
        $charts[] = $chart;
        
        return $this->render('GoogleChartBundle:Showroom:charts.twig', array('charts' => $charts));
    }
    
    protected function getRandomData($size) {
        $values = $keys = array();
        for ($i=0; $i < $size; $i++) {
            $values[] = rand(0, 100);
            $keys[] = $i;
        }
        return array_combine($keys, $values);
    }
    
}
