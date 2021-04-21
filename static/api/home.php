<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/User.php');
    include_once(realpath(dirname(__DIR__)) . '/classes/House.php');

    $house = new House();
    
    //get all houses
    $all_id = $house -> getAllHouseId();
    //print_r($all_id);
    $all_houses = array();
    for($i=0; $i<count($all_id); $i++){
        $house -> house_id = $all_id[$i];
        $house_name = json_decode($house -> getHouseById()) -> name;
        $all_houses[$all_id[$i]] = $house_name; 
    }
?>