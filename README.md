GoogleChartBundle v0.1.0
========================

This bundle simplifies work with [Google Chart API](http://code.google.com/apis/chart/).

How does it look like
---------------------

![GoogleChartBundle - default settings] (https://chart.googleapis.com/chart?cht=lxy&chs=300x200&chd=t:-1|47.423,23.711,71.134,79.381,94.845,86.598,58.763,17.526,79.381,54.639,70.103,45.361,80.412,36.082,17.526,51.546,57.732,100,59.794,6.186&chtt=Default+settings&chxt=x,y&chxr=0,0,19|1,0,97&chco=f07d00)

![GoogleChartBundle example #2] (https://chart.googleapis.com/chart?cht=lxy&chs=400x200&chd=t:-1|48.5,36,63,44.5,54.5,70,36.5,67,29.5,48.5,61.5,53,60,46,41,55.5,37.5,70,64,26&chtt=example+%232&chxt=x,y&chxr=0,0,19|1,-50,150&chco=f07d00)

![GoogleChartBundle example #3] (https://chart.googleapis.com/chart?cht=lxy&chs=400x200&chd=t:-1|52,48,56,55,58,48,44,43,58,43,48,40,52,43,59,48,41,46,59,50|-1|50,74,53,56,23,72,77,63,78,68,74,56,63,47,24,68,60,72,34,35|-1|77,64,71,45,42,23,76,69,78,40,21,59,21,62,49,67,27,75,80,64|-1|26,100,81,30,69,14,81,25,93,96,51,68,24,68,73,73,20,80,7,51,51,65,70,92,36,13,84,25,20,23&chtt=example+%233&chxt=x,y&chxr=0,0,29&chco=3996B9,2775CB,46CAF0,bbbbbb&chls=4|3|2|1)

Known limitations
-----------------

By now, only **line charts** are available with some limitations.
The most important is probably that X axis is not scalable and there's no support for grids, but these things will be fixed as soon as posible.
Implementation is not 100%, so all features are not available at this moment.
Also complete documentation with deeper description and more examples will be available soon.

Installation
------------

From GitHub:

    git@github.com:martinsik/GoogleChartBundle.git

or download and unzip:

    https://github.com/martinsik/GoogleChartBundle

Register bundle in your XXXKernel.php:

    new Bundle\GoogleChartBundle\GoogleChartBundle()


How to use it
-------------

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Bundle\GoogleChartBundle\Library\LineChart\LineChart;
    use Bundle\GoogleChartBundle\Library\LineChart\Line;

    class HelloController extends Controller {

        public function indexAction() {
            $chart = new LineChart(array('title' => 'Default settings'));
            $line = new Line();
            $line->add(array(20, 50, 10, 30, 45, 87, 60, 10, 25, 70));
            $chart->addLine($line);

            return $this->render('HelloBundle:Hello:index.twig.html', array('chart' => $chart));
        }
    }

rendering in Twig:

    {# render <img> tag #}
    {{ chart.render }}

    {# or just get image url #}
    {{ chart.renderUrl }}
    

or in PHP view:

    <!-- render <img> tag -->
    <?php echo $chart->render(); ?>

    <!-- or just get image url -->
    <?php echo $chart->renderUrl(); ?>

