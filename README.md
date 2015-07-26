# Google Chart Generator

PHP 5.4+ wrapper around [Google Chart API](https://developers.google.com/chart/interactive/docs/) based on [Polymer 1.0 component `<google-chart>`](https://elements.polymer-project.org/elements/google-chart).

## Installation

Add `composer.json` dependency:

```
"require": {
    "martinsik/google-chart-generator": "^2.0.0"
}
```

Add `bower.json` dependency (Polymer 1.0):

```
"dependencies": {
    "google-chart": "GoogleWebComponents/google-chart#^1.0.0"
}
```

Eventually, install `google-chart` Polymer component [as you want](https://www.polymer-project.org/1.0/docs/start/getting-the-code.html).

## Charts

Right now, four chart types are supported: [line](https://developers.google.com/chart/interactive/docs/gallery/linechart), [bar](https://developers.google.com/chart/interactive/docs/gallery/barchart), [column](https://developers.google.com/chart/interactive/docs/gallery/columnchart) and [pie](https://developers.google.com/chart/interactive/docs/gallery/piechart) charts.

The PHP wrapper is very liberal, it lets you set any Google Chart options via data or chart options. It doesn't have special methods for every possible option because there are are so many of them and it doesn't make sense to make wrappers for every single one of them.

To use any chart you have to import Polymer 1.0 <google-chart> element and WebComponents polyfill first:

```
<!-- Polyfill Web Components support for older browsers -->
<script src="/bower_components/webcomponentsjs/webcomponents.min.js"></script>

<!-- Import element -->
<link rel="import" href="/bower_components/google-chart/google-chart.html">
```

### Line chart

Creating a line chart:

```php
$chart = new LineChart(['title' => 'Test Chart #1']);
$chart->addData(new SequenceData([12, 24, 20, 18, 16, 45, 23, 15, 65, 32], ['label' => 'Line #1']));
$chart->addData(new SequenceData([31, 27, 31, 28, 30, 40, 52, 48, 78, 45], ['label' => 'Line #2']));
```

Get element HTML with `$chart->getElement()`.

```html
<google-chart style=""
    type='line'
    options='{"title":"Test Chart #1"}'
    cols='[{"type":"string"},{"type":"number","label":"Line #1"},{"type":"number","label":"Line #2"}]'
    rows='[["0",12,31],["1",24,27],["2",20,31],["3",18,28],["4",16,30],["5",45,40],["6",23,52],["7",15,48],["8",65,78],["9",32,45]]'>
</google-chart>
```

See all possible options for [line charts](https://developers.google.com/chart/interactive/docs/gallery/linechart).

The above code would result into this chart.

![Example Line Chart](https://raw.githubusercontent.com/martinsik/google-chart-generator/master/doc/line-chart.png)

### Pie chart

Creating pie chart:

```php
$chart = new PieChart(['width' => '150px', 'height' => '150px', 'pieHole' => 0.5]);
$chart->addData([new SingleData(40, 'Arc #1'), new SingleData(60, 'Arc #2'), new SingleData(80, 'Arc #3')]);
```

Get element HTML with `$chart->getElement()`.

```html
<google-chart style="width:150px;height:150px;"
    type='pie'
    options='{"pieHole":0.5}'
    cols='[{"type":"string","label":"Title"},{"type":"number","label":"Value"}]'
    rows='[["Arc #1",40],["Arc #2",60],["Arc #3",80]]'>
</google-chart>
```

See all possible options for [pie charts](https://developers.google.com/chart/interactive/docs/gallery/piechart).

### Bar chart

Creating bar chart:

```php
$chart = new BarChart();
$chart->addData(new SequenceData([20, 40, 30]));
```

Get element HTML with `$chart->getElement()`.

```html
<google-chart style=""
    type='bar'
    options='[]'
    cols='[{"type":"string"},{"type":"number"}]'
    rows='[["0",20],["1",40],["2",30]]'>
</google-chart>
```

See all possible options for [bar charts](https://developers.google.com/chart/interactive/docs/gallery/barchart).

### Column chart

Creating column chart:

```php
$chart = new ColumnChart(['width' => '700px', 'isStacked' => true, 'legend' => ['position' => 'none']]);
$chart->addData(new SequenceData(["a1" => 20, "a2" => 40, "a3" => 30], ['label' => 'aaa']));
$chart->addData(new SequenceData(["a1" => 15, "a2" => 32, "a3" => 34], ['label' => 'bbb']));
$chart->addData(new SequenceData(["a1" => 21, "a2" => 42, "a3" => 17], ['label' => 'ccc']));
```

Get element HTML with `$chart->getElement()`.

```html
<google-chart style="width:700px;"
    type='bar'
    options='{"isStacked":true,"legend":{"position":"none"}}'
    cols='[{"type":"string"},{"type":"number","label":"aaa"},{"type":"number","label":"bbb"},{"type":"number","label":"ccc"}]'
    rows='[["a1",20,15,21],["a2",40,32,42],["a3",30,34,17]]'>
</google-chart>
```

See all possible options for [column charts](https://developers.google.com/chart/interactive/docs/gallery/columnchart).

## Tests

All tests in this project are based on [behat](docs.behat.org/).

```
$ bin/behat
```