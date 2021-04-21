<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/House.php');

    $house = new House();
    $all_house_id = $house -> getAllHouseId();
    $no_of_houses = count($house);

    $each_house = array();
    $all_houses = array();

    //print_r(json_decode(json_decode($house -> getHouseById()) -> pic_url));

    foreach($all_house_id as $house_id){
        $house -> house_id = $house_id;
        $house_info = json_decode($house -> getHouseById());

        $each_house[count($each_house)] = $house_info -> name;
        $each_house[count($each_house)] = $house_info -> location;
        $each_house[count($each_house)] = $house_info -> vacancy;
        $each_house[count($each_house)] = $house_info -> rent;
        $each_house[count($each_house)] = $house_info -> type;
        $each_house[count($each_house)] = $house_info -> owner_contact;
        $each_house[count($each_house)] = $house_info -> house_id;

        $all_houses[count($all_houses)] = $each_house;
        $each_house = array();
    }
    //print_r($all_houses);
?>