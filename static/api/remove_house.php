<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/House.php');
    $house = new House();
    
    $house_id = isset($_POST['house_id']) ? $_POST['house_id'] : die(http_response_code(403));
    $house -> house_id = $house_id;
    if($house -> getHouseById() == '0'){
        die(http_response_code(501));
    }
    $pic_url = json_decode(json_decode($house -> getHouseById()) -> pic_url);

    if(count($pic_url) > 0){
        for($i=0; $i<count($pic_url); $i++){
            $cmd = "rm " . realpath(dirname(__DIR__)) . "/images/houses/" . $pic_url[$i];
            system($cmd);
        }
    }
    if($house -> removeHouse() == '0'){
        die(http_response_code(501));
    }
    echo "House removed.";
    die(http_response_code(200));
?>