Feature: line-chart
  In order create a proper line chart compatible with Angular 1.0
  As a developer
  I need to be sure that the code generated is correct with what the Angular 1.0 element expects

  Scenario:
    Given a set of test data to create multiple line charts
    Then compare charts with expected values
    And manually check their results with expected HTML templates in "./generated_html" as "line-chart.html"