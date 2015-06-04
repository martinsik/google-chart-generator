<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use GoogleChartGenerator\Mock\DummyChart;
use GoogleChartGenerator\Mock\DummyDataCollection;
use GoogleChartGenerator\Mock\DummySequentialDataCollection;

/**
 * Features context.
 */
class DataCollectionContext extends BehatContext {

    private $sets = [];
    private $expected = [];

    /**
     * @Given /^example data sets with basic types$/
     */
    public function exampleDataSetsWithBasicTypes()
    {
        $this->sets[] = new DummyDataCollection([2, 3, 4, 6, 7, 8]);
        $this->expected[] = [2, 3, 4, 6, 7, 8];

        $this->sets[] = new DummyDataCollection(42);
        $this->expected[] = 42;

        $this->sets[] = new DummyDataCollection("I'm a string value");
        $this->expected[] = "I'm a string value";
    }

    /**
     * @Then /^create multiple sequential data sets$/
     */
    public function createMultipleSequentialDataSets()
    {
        $set = new DummySequentialDataCollection([1, 2, 3]);
        $set->add(4);
        $this->sets[] = $set;
        $this->expected[] = [1, 2, 3, 4];

        $set = new DummySequentialDataCollection([1, 2, 3]);
        $set->add([4, 5, 6], 2);
        $this->sets[] = $set;
        $this->expected[] = [1, 2, 4, 5, 6, 3];

        $set = new DummySequentialDataCollection([1, 2, 3]);
        $set->add(5, 1);
        $this->sets[] = $set;
        $this->expected[] = [1, 5, 3];

        $set = new DummySequentialDataCollection();
        $set->add(12, 1);
        $set->add(42, 5);
        $set->add(49, 6);
        $set->add(32, 3);
        $this->sets[] = $set;
        $this->expected[] = [1 => 12, 5 => 42, 6 => 49, 3 => 32];
    }

    /**
     * @Then /^test basic data collections and manipulation with expected values$/
     */
    public function testBasicDataCollectionsAndManipulationWithExpectedValues()
    {
        foreach ($this->sets as $index => $set) {
            /** @var \GoogleChartGenerator\Chart\AbstractChart $set */
            assertEquals($set->getData(), $this->expected[$index]);
        }
    }

}