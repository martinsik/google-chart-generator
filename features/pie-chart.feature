Feature: pie-chart
  In order create a proper pie chart compatible with Angular 1.0
  As a developer
  I need to be sure that the code generated is correct with what the Angular 1.0 element expects

  Scenario:
    Given a set of test data to create multiple pie charts
    Then compare pie charts with expected values and manually check their results with expected HTML templates in "./generated_html" as "pie-chart.html"