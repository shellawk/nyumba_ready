<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/User.php');
    include_once(realpath(dirname(__DIR__)) . '/classes/Review.php');
    include_once(realpath(dirname(__DIR__)) . '/classes/Book.php');

    $user = new User();
    $review = new Review();
    $book = new Book();

    $user_id =isset($_POST['user_id']) ? $_POST['user_id'] : die(http_response_code(403));
    $user -> user_id = $user_id;
    $review -> user_id = $user_id;
    
    //remove_pic
    if(strlen(json_decode($user -> getUserById()) -> pic_url) > 0){
        system("rm " . realpath(dirname(__DIR__)) . "/images/users/" . json_decode($user -> getUserById()) -> pic_url);
    }
    //remove user
    if($user -> removeUser() == '0'){
        http_response_code(501);
    }
    //delete all reviews by user
    if($review -> removeReviewByUserId() == '0'){
        http_response_code(501);
        die();
    }
    $book -> user_id = $user_id;
    if($book -> deleteBookRecordByUser() == '0'){
        http_response_code(501);
        die();
    }
    http_response_code(200);
    echo "User removed.";
    die();
?>