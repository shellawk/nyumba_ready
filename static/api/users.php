<?php
    include_once(realpath(dirname(__DIR__)) . "/classes/User.php");

    $user = new User();
    $all_user_id = $user -> getAllUserId();
    $no_of_users = count($all_user_id);
    $all_users = array();
    $each_user = array();
    foreach($all_user_id as $user_id){
        $user -> user_id = $user_id;
        $data = json_decode($user -> getUserById());
        $each_user['id'] = $data -> user_id;
        $each_user['name'] = $data -> firstname . " "  . $data -> lastname;
        $each_user['email'] = $data -> email;
        $each_user['pic'] = strlen($data -> pic_url) > 5 ? $data -> pic_url : 'pic.png';
        $all_users[count($all_users)] = $each_user;
    }
?>