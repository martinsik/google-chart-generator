<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Mock\DummyChart;

/**
 * Features context.
 */
class OptionsContext extends BehatContext {

    private $mockObjects = [];
    private $expectedOptions = [];

    /**
     * @Given /^a set of chart objects with options$/
     */
    public function aSetOfChartObjectsWithOptions()
    {
        $obj1 = new DummyChart();
        assertInstanceOf('GoogleChartGenerator\Mock\DummyChart', $obj1->setTitle('Dummy Chart #1'));
        $this->mockObjects['obj1'] = $obj1;
        $this->expectedOptions['obj1'] = ["title" => "Dummy Chart #1"];

    }

    /**
     * @Then /^compare them with their expected results$/
     */
    public function compareThemWithTheirExpectedResults()
    {
//        $method = new \ReflectionMethod('GoogleChartGenerator\Mock\DummyChart', 'getOptions');
//        $method->setAccessible(true);
//        $result = $method->invoke($obj);

        foreach ($this->mockObjects as $key => $obj) {
            /** @var $obj DummyChart */
            $result = $obj->getOptions();
            assertEquals($this->expectedOptions[$key], $result);
        }
    }

}
