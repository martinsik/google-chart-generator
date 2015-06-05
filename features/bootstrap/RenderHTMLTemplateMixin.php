<?php

trait RenderHTMLTemplateMixin {

    public function render($dir, $filename, $elements) {
        $dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '/../' . DIRECTORY_SEPARATOR . $dir);
        @mkdir($dir);
        $filePath = $dir . DIRECTORY_SEPARATOR . $filename;

        @unlink($filePath);
        $html = file_get_contents($dir . DIRECTORY_SEPARATOR . '_template.html');
        $actualHtml = array_map(function($html) {
            return '<div><div>' . $html . '</div><pre>' . htmlentities($html) . '</pre></div>';
        }, $elements);

        $html = str_replace('__CONTENT__', implode('', $actualHtml), $html);
        file_put_contents($filePath, $html);
    }

}
