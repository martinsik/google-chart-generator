Feature: axis-chart
  In order to use charts with multiple sets of sequential data
  As a developer
  I need to properly work with data in various ranges

  Scenario:
    Given charts with multiple data sets each with different ranges
    Then check their ranges cover all data sets
    And prepared rows cover entire range with missing values filled

    Then default axes aren't rendered at all
