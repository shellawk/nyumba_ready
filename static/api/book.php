<?php
    include_once(realpath(dirname(__DIR__)) . "/classes/User.php");
    include_once(realpath(dirname(__DIR__)) . "/classes/House.php");
    include_once(realpath(dirname(__DIR__)) . "/classes/Book.php");

    $user = new User();
    $house = new House();
    $book = new Book();

    $redirect_path = (realpath(dirname(__DIR__ ) . "../../test.php"));
    if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS'] == 'on'){
        $url = "https://";
    }else{
        $url = "http://";
    }
    $url .= $_SERVER['HTTP_HOST'] . "/pesapal-iframe.php"; //

    $user_id = isset($_COOKIE['token']) ? $_COOKIE['token'] : errMsg("Please login to book.");
    function errMsg($msg){
        echo '<p id="p-err-msg">' . $msg . '</p>';
        die(http_response_code(403));
    }
    $house_id = isset($_POST['house_id']) ? $_POST['house_id'] : die(http_response_code(403));

    //get user
    $user -> user_id =$user_id;
    $user_info = $user -> getUserById() != '0' ? json_decode($user -> getUserById()) : die(http_response_code(403));

    //check for pending bookings
    $book -> user_id = $user_id;
    if($book -> getBookRecordByUserId() != '0' && json_decode($book -> getBookRecordByUserId()) -> status == '0'){
        $p_info = json_decode($book -> getBookRecordByUserId());
        $p_reference = $p_info -> pesapal_merchant_reference;
        $p_user_id = $p_info -> user_id;
        $p_amount = $p_info -> amount;
        $p_desc = $p_info -> house_id;

        $p_user = new User();
        $p_user -> user_id = $p_user_id;
        $p_user_info = json_decode($p_user -> getUserById());
        $p_firstname = $p_user_info -> firstname;
        $p_lastname = $p_user_info -> lastname;
        $p_email = $p_user_info -> email;

        $p_house = new House();
        $p_house -> house_id = $p_info -> house_id;
        $p_house_name = json_decode($p_house -> getHouseById()) -> name;
        include_once('pending_book.php');
        die(http_response_code(200));
    }
    //get house
    $house -> house_id = $house_id;
    $house_info = $house -> getHouseById() != '0' ? json_decode($house -> getHouseById()) : die(http_response_code(403));

    //AMOUNT is 10% of house rent
    $amount = $house_info -> rent * 0.1;

    //add booking to db
    $reference = md5(uniqid());
    $book -> pesapal_merchant_reference = $reference;
    $book -> user_id = $user_id;
    $book -> house_id = $house_id;
    $book -> amount = $amount;
    if($book -> createBookRecord() == '0'){
        http_response_code(501);
        errMsg("Internal Server Error.");
    }
    http_response_code(200);
?>