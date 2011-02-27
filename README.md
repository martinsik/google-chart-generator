GoogleChartBundle v0.1.2
========================

Bundle for comfy implementation of [Google Chart API](http://code.google.com/apis/chart/).

How does it look like
---------------------

 - Line Chart
   - [default setting](http://chart.googleapis.com/chart?cht=lxy&chs=300x200&chd=t:-1|83,32,56,38,50,65,18,50,65,54,40,100,22,4,41,7&chtt=GoogleChartBundle+with+default+settings&chxt=x,y&chxr=0,0,19|1,0,100&chco=ffa909&chg=25,33.33,3,3)
   - [more lines, colors, widths, legend](http://chart.googleapis.com/chart?cht=lxy&chs=800x200&chd=t:-1|46,11,29,22,39,43,20,91,28,70,50,91,63,8,36,33,14,85,27,94|-1|58,55,40,44,58,60,58,54,48,59,47,47,47,47,40,59,45,44,46,46|-1|28,47,79,34,43,45,44,73,38,64,46,62,38,54,61,41,74,79,63,62|-1|40,56,66,45,76,63,63,76,72,62,45,28,50,27,75,23,54,42,21,46&chtt=Line+chart+generated+by+GoogleChartBundle&chdlp=b&chdl=grey+line|Line+%231|Line+%232|Line+%233&chxt=x,y&chxr=0,0,19&chco=eeeeee,ffa909,26348c,4fc400&chg=16.7,25,3,3&chls=1|4|3|2)
   - [sparkline](https://chart.googleapis.com/chart?cht=ls&chs=180x80&chd=t:-1|8,10,23,13,18,5,3,48,58,43,67,48,85,100,95,10,3,2&chxr=0,0,17|1,0,60&chco=000088 "sparkline")
 - Pie Chart
   - [default setting](http://chart.googleapis.com/chart?cht=p&chs=300x200&chd=t:40,60,30&chtt=Default+settings&chco=ffa909,26348c,4fc400)
   - [more slices with legend](http://chart.googleapis.com/chart?cht=p&chs=300x200&chd=t:19,15,13,3&chtt=more+slices+with+legend&chco=ffa909,26348c,4fc400,e40613&chdl=Arc+%231|Arc+%232|Arc+%233|Arc+%234)
   - [3D chart](http://chart.googleapis.com/chart?cht=p3&chs=300x200&chd=t:9,24,30,5&chtt=3D+chart&chco=ffa909,26348c,4fc400,e40613&chdl=Arc+%231|Arc+%232|Arc+%233|Arc+%234)
 - Bar Chart
   - [default setting](http://chart.googleapis.com/chart?cht=bvg&chs=300x200&chd=t:25,100,37,17,6,100&chtt=Default+settings&chco=ffa909&chxt=x,y&chxr=0,0,5|1,0,65&chg=0,33.3,3,3)
   - [stacked and vertical](http://chart.googleapis.com/chart?cht=bvs&chs=300x200&chd=t:48,24,30,45,37,11|52,46,47,9,53,50&chtt=stacked+and+vertical&chco=ffa909,26348c&chxt=x,y&chxr=0,0,5|1,0,177&chg=0,33.3,3,3)
   - [stacked and horizontal](http://chart.googleapis.com/chart?cht=bhs&chs=300x210&chd=t:21,2,41,36,35,18|49,26,45,19,13,23|31,8,11,21,18,6&chtt=stacked+and+horizontal&chco=ffa909,26348c,4fc400&chxt=y,x&chxr=0,0,5|1,0,160&chg=25,0,3,3)

Documentation
-------------

For deeper information about this bundle visit [GoogleChartBundle documentation](http://www.martinsikora.com/googlechartbundle "GoogleChartBundle documentation").

Installation
------------

###Download the Source Code

From GitHub repository [git@github.com:martinsik/GoogleChartBundle.git](https://github.com/martinsik/GoogleChartBundle "git@github.com:martinsik/GoogleChartBundle.git"):

    git clone git@github.com:martinsik/GoogleChartBundle.git __my_project__/src/Bundle/GoogleChartBundle

or download and unzip latest version from:

    https://github.com/martinsik/GoogleChartBundle

and put all content into `__my_project__/src/Bundle/GoogleChartBundle`

###Enable Bundle

**NOTE:** Guidelines for Symfony2 PR6, for older versions might be slightly different.

Register bundle in your `XXXKernel.php`:

    // app/AppKernel.php
    new Bundle\GoogleChartBundle\GoogleChartBundle()

Register default bundle namespace in your `autoload.php`:

    // app/autoload.php
    $loader->registerNamespaces(array(
        'Symfony'  => __DIR__ . '/../vendor/symfony/src',
        ...
        'Bundle'   => __DIR__ . '/../src',
    ));


Quick Tutorial
--------------

defining a line chart:

    $chart = new LineChart(array('title' => 'Chart with default settings'));
    $chart->addLine(new Line(array(83,32,56,38,50,65,18,50,65,54,40,100,22,4,41,7)));

rendering in a Twig view:

    {# render <img> tag #}
    {{ chart.render }}

    {# or just get image url #}
    {{ chart.renderUrl }}
    

or in a PHP view:

    <!-- render <img> tag -->
    <?php echo $chart->render(); ?>

    <!-- or just get image url -->
    <?php echo $chart->renderUrl(); ?>

Generated HTML output is:

    <!-- render <img> tag -->
    <img src="http://chart.googleapis.com/chart?cht=lxy&chs=300x200&chd=t:-1|83,32,56,38,50,65,18,50,65,54,40,100,22,4,41,7&chtt=Chart+with+default+settings&chxt=x,y&chxr=0,0,19|1,0,100&chco=ffa909&chg=25,33.33,3,3" width="300" height="200" alt="GoogleChartBundle with default settings" />

    <!-- or just get image url -->
    http://chart.googleapis.com/chart?cht=lxy&chs=300x200&chd=t:-1|83,32,56,38,50,65,18,50,65,54,40,100,22,4,41,7&chtt=Chart+with+default+settings&chxt=x,y&chxr=0,0,19|1,0,100&chco=ffa909&chg=25,33.33,3,3

and finally the image:

[show generated chart](http://chart.googleapis.com/chart?cht=lxy&chs=300x200&chd=t:-1|83,32,56,38,50,65,18,50,65,54,40,100,22,4,41,7&chtt=GoogleChartBundle+with+default+settings&chxt=x,y&chxr=0,0,19|1,0,100&chco=ffa909&chg=25,33.33,3,3 "GoogleChartBundle with default settings")
