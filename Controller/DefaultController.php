<?php

namespace Bundle\GoogleChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\GoogleChartBundle\Library\LineChart\LineChart;
use Bundle\GoogleChartBundle\Library\LineChart\Line;

class DefaultController extends Controller {
    
    public function lineChartAction() {
        $chart1 = new LineChart();
        $chart1->setSize('400x200');
        $line = new Line();
        $line->add($this->getRandomData(20));
        $chart1->addData($line);
        
        return $this->render('GoogleChartBundle:Default:index.twig', array('chart1' => $chart1));
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
