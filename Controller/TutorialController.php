<?php

namespace Bundle\GoogleChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\GoogleChartBundle\Library\LineChart\LineChart;
use Bundle\GoogleChartBundle\Library\LineChart\Line;

class TutorialController extends Controller {
    
    public function indexAction() {
        $chart = new LineChart();
        $chart->setSize('800x200');
        $chart->setTitle('GoogleChartBundle tutorial');
        
        $chart->addLine(new Line(array(73,50,83,15,38,17,0,27,92,86,68,83,93,27,17,28,51,64,35,62)));
        
        $line = new Line(array(58,46,45,58,51,40,46,55,44,60,55,60,60,48,46,51,47,60,48));
        $line->add(40);
        $line->setColor('8c579d');
        $line->setWidth(3);
        $chart->addLine($line);
        
        //$chart->addLine(new Line(array(50,76,74,37,20,80,24,70,78,43,69,58,76,69,46,28,22,51,69,40)));
        $chart->addLine(new Line(array(5=>52, 6=>32, 7=>36, 8=>61, 9=>53, 10=>24, 15=>59, 16=>29, 17=>5)));
        
        return $this->render('GoogleChartBundle:Showroom:tutorial.twig', array('chart' => $chart));
    }
    
}