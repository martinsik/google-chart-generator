<?php

use GoogleChartGenerator\Mock\DummyChart;

class CommonChartContext extends AbstractChartContext {

    /**
     * @Given /^a set of test dummy charts$/
     */
    public function aSetOfTestDummyCharts()
    {
        $chart = new DummyChart([
            'width' => '100',
            'height' => '150',
            'elmWidth' => '300px',
            'elmHeight' => '400px',
        ]);
        $this->charts[] = $chart;
        $this->expected[] = [
            'options' => [
                'width' => '100',
                'height' => '150'
            ],
            'attributes' => [
                'width' => '300px',
                'height' => '400px',
            ],
        ];
    }

    /**
     * @Then /^these have to generate expected options$/
     */
    public function theseHaveToGenerateExpectedOptions()
    {
        foreach ($this->charts as $index => $chart) {
            assertEquals($this->expected[$index]['options'], $chart->getOptions());
            assertEquals($this->expected[$index]['attributes'], $chart->getAttributes());
        }
    }



}