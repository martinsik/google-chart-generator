<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;


class FeatureContext extends BehatContext {

    public function __construct(array $parameters) {
        $this->useContext('options_subcontext_alias', new OptionsContext());
        $this->useContext('data_collection_subcontext_alias', new DataCollectionContext());
    }

}