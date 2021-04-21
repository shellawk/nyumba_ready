<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/Review.php');
    include_once(realpath(dirname(__DIR__)) . '/classes/User.php');
    
    $review = new Review();
    $user = new User();

    if(isset($_COOKIE['token']) && isset($_POST['content'])){
        $user -> user_id = $_COOKIE['token'];
        if($user -> getUserById() == '0'){
            http_response_code(501);
            die();
        }
        $review -> user_id = $_COOKIE['token'];
        $review -> content = $_POST['content'];
        if($review -> createReview() == '1'){
            http_response_code(200);
            die();
        }
        http_response_code(500);
    }
?>