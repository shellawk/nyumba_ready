<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/House.php');

    $house = new House();
    if(isset($_POST['house_id'])){
        $house -> house_id = $_POST['house_id'];
        print_r($house -> getHouseById());
    }
?>