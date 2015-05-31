Feature: data-collections
  In order to comfortably work with data in PHP
  As a developer
  I need to have comfortable wrapper around Chart's data sets

  Scenario: Test creating various data sets with their expected values
    Given example data sets
    Then compare them with expected values