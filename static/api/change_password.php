<?php
    include_once(realpath(dirname(__DIR__)) . "/classes/User.php");
    $user = new User();

    if(isset($_POST['password']) && $_COOKIE['token']){
        if(strlen($_POST['password']) < 8){
            http_response_code(501);
            die("Password less than 8 characters");
        }
        $user -> user_id = $_COOKIE['token'];
        if($user -> getUserById() == '0'){
            http_response_code(501);
            die("Nice try.");
        }
        $user -> password = $_POST['password'];
        
        if($user -> updateUserInfo() == '0'){
            http_response_code(501);
            die("Error changing password.");
        }
        die();
    }
    http_response_code(404);
?>