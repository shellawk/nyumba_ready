<?php
    include_once(realpath(dirname(__DIR__)) . "/classes/Admin.php");

    $admin = new Admin();

    $username = isset($_POST['username']) ? $_POST['username'] : die(http_response_code(403));
    $password = isset($_POST['password']) ? $_POST['password'] : die(http_response_code(403));

    $admin -> username = $username;
    $admin -> password = $password;
    $auth_token = $admin -> getAdminId();
    if($auth_token == '0'){
        die(http_response_code(403));
    }
    echo $auth_token;
    die(http_response_code(200));
?>