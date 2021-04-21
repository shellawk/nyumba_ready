<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/User.php');
    $user = new User();

    $user -> email = isset($_POST['email']) ? $_POST['email'] : die(http_response_code(403));
    $user -> password = isset($_POST['password']) ? $_POST['password'] : die(http_response_code(403));
    
    //check user exists
    if($user -> getUserByEmail() == '0'){
        http_response_code(501);
        die("User Does Not Exist.");
    }
    if(json_decode($user -> getUserByEmail()) -> password != md5($_POST['password'])){
        http_response_code(501);
        die("Wrong Username or Password");
        print_r(json_decode($user -> getUserByEmail()) -> password);
    }
    echo $token = json_decode($user -> getUserByEmail()) -> user_id;
    http_response_code(200);
?>