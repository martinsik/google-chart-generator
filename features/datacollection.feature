Feature: data-collections
  In order to comfortably work with data in PHP that are going to be rendered as parameters to <google-chart> element
  As a developer
  I need to have wrapper around Chart's data sets

  Scenario: Create various data sets with basic types
    Given example data sets with basic types
    Then create multiple sequential data sets
    Then test basic data collections and manipulation with expected values

  Scenario:
    Given example option parameters
    Then make sure these are properly filtered to only series options and only column options
