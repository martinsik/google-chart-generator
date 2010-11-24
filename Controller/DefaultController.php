<?php

namespace Bundle\GoogleChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GoogleChartBundle:Default:index');
    }
}
