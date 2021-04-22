<?php

$url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
$url .= $_SERVER['HTTP_HOST'];

echo dirname(__DIR__);

?>