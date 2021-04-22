<?php
$url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
$url .= $_SERVER['HTTP_HOST'];
$api_url = $url;
$path = basename(__DIR__);
$prev_path = basename(realpath(dirname(__DIR__))) != 'htdocs' ? basename(realpath(dirname(__DIR__))) : '';
$path = $prev_path . "/" . $path;
$current_url = $url . "/" . $path;
$api_url .= "/" . $prev_path . "/static/api/";
?>