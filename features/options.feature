Feature: options
  In order to set chart's options
  As a developer using Google Chart API
  I need to be render proper JavaScript code for the chart's options

  Scenario: Test various options configurations with generated JavaScript code
    Given a set of chart objects with options
    Then compare them with their expected results