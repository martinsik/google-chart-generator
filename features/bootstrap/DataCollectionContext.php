<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Mock\DummyChart;
use GoogleChartGenerator\Mock\DummyDataCollection;

/**
 * Features context.
 */
class DataCollectionContext extends BehatContext {

    private $sets = [];
    private $expected = [];

    /**
     * @Given /^example data sets$/
     */
    public function exampleDataSets()
    {
        $this->sets[0] = new DummyDataCollection([2, 3, 4, 6, 7, 8]);
        $this->expected[0] = [2, 3, 4, 6, 7, 8];

        $this->sets[1] = new DummyDataCollection(42);
        $this->expected[1] = 42;

        $this->sets[2] = new DummyDataCollection("I'm a string value");
        $this->expected[2] = "I'm a string value";
    }

    /**
     * @Then /^compare them with expected values$/
     */
    public function compareThemWithExpectedValues()
    {
        foreach ($this->sets as $index => $set) {
            /** @var \GoogleChartGenerator\Chart\AbstractChart $set */
            assertEquals($set->getTitle(), "Data title #" . ($index + 1));
            assertEquals($set->getData(), $this->expected[$index]);
        }
    }

}