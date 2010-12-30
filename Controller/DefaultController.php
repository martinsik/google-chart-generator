<?php

namespace Bundle\GoogleChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\GoogleChartBundle\Library\LineChart;

class DefaultController extends Controller {
    
    public function indexAction() {
        $chart = new LineChart();
        return $this->render('GoogleChartBundle:Default:index.twig');
    }
    
}
