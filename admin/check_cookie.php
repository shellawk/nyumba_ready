<?php 
    include_once(realpath(dirname(__DIR__)) . '/static/classes/Admin.php');
    $admin = new Admin();

    $logged_in = '0';
    $admin -> admin_id = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : '';
    $logged_in = $admin -> checkAdminId();

?>