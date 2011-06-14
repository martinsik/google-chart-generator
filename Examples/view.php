<?php 
function niceDump($chartUrl) {
    $chartUrl = preg_replace('/([\&|\?])(.*)\=/U', '\1<span class="option">\2</span>=', $chartUrl);
    return $chartUrl;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>GoogleChartGenerator</title>
        
        <style>
        body { padding: 0; margin: 0; }
        h1 { font-size: 20px; }
        .tabs { width: 100%; }
        .tabs > div { padding: 5px; }
        .tabs > div pre { border: 1px solid #ddd; border-radius: 3px; padding: 5px; background: #eee;  }
        span.option { color: green; }
        .ui-tabs-hide { display: none; }
        </style>

    </head>
    <body>
		<?php foreach ($charts as $index => $chart) : ?>
            <div class="tabs">
                <ul>
                    <li><a href="#tab-chart<?php echo $index; ?>-image">image</a></li>
                    <li><a href="#tab-chart<?php echo $index; ?>-url">url</a></li>
                    <li><a href="#tab-chart<?php echo $index; ?>-data">data</a></li>
                    <li><a href="#tab-chart<?php echo $index; ?>-options">options</a></li>
                </ul>
                <div id="tab-chart<?php echo $index; ?>-image"><?php echo $chart->render(); ?></div>
                <div id="tab-chart<?php echo $index; ?>-url"><pre><?php echo niceDump($chart->debugUrl()); ?></pre></div>
                <div id="tab-chart<?php echo $index; ?>-data"><pre><?php print_r($chart->getData()); ?></pre></div>
                <div id="tab-chart<?php echo $index; ?>-options"><pre><?php print_r($chart->getOptions()); ?></pre></div>
            </div>
		<?php endforeach; ?>
		        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> 
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script> 
        
        <script type="text/javascript">
        $(function() {
            $('.tabs').tabs();
        });
        </script>
    </body>
</html>
