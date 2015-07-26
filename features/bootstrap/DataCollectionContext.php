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
    private $sets2 = [];
    private $expected = [];

    private $expectedOptions = [];
    private $expectedColumnOptions = [];

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

    /**
     * @Given /^example option parameters$/
     */
    public function exampleOptionParameters()
    {
        $this->sets2[] = new DummyDataCollection([], ['type' => 'string', 'lineWidth' => '3']);
        $this->expectedOptions[] = ['lineWidth' => '3'];
        $this->expectedColumnOptions[] = ['type' => 'string'];

        $this->sets2[] = new DummySequentialDataCollection([], ['lineWidth' => '2']);
        $this->expectedOptions[] = ['lineWidth' => '2'];
        $this->expectedColumnOptions[] = ['type' => 'number'];
    }

    /**
     * @Then /^make sure these are properly filtered to only series options and only column options$/
     */
    public function makeSureTheseAreProperlyFilteredToOnlySeriesOptionsAndOnlyColumnOptions()
    {
        foreach ($this->sets2 as $index => $set) {
            /** @var \GoogleChartGenerator\Chart\AbstractChart $set */
            assertEquals($this->expectedOptions[$index], $set->getOptions());
            assertEquals($this->expectedColumnOptions[$index], $set->getColumnOptions());
        }
    }

    /**
     * @Given /^only column options$/
     */
    public function onlyColumnOptions()
    {
        throw new PendingException();
    }
}