<?php

use Behat\Behat\Context\BehatContext;

abstract class AbstractChartContext extends BehatContext
{
    protected $charts = [];
    protected $expected = [];
}