<?php
//Send post request with house_id value
    include_once(realpath(dirname(__DIR__)) . '/classes/User.php');
    include_once(realpath(dirname(__DIR__)) . '/classes/Review.php');

    $user = new User();
    $review = new Review();

    $reviews = array();
    $review_info = array();
    //get all reviews id
    $all_reviews_id = $review -> getAllReviewId();
    $count = 0;
    foreach($all_reviews_id as $review_id){
        $review -> review_id = $review_id;
        $result = $review -> getReviewById();

        $user -> user_id = $result['user_id'];
        $user_info = json_decode($user -> getUserById());
        
        //arrange review info
        $review_info['name'] = $user_info -> firstname . " " . $user_info -> lastname;
        $review_info['pic'] = $user_info -> pic_url == '' ? 'pic.png' : $user_info -> pic_url;
        $review_info['content'] = $result['content'];

        $reviews[$count] = $review_info;
        $count += 1;
    }
    $reviews = json_encode($reviews);
    print_r($reviews);
?>