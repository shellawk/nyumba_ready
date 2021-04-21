<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/House.php');
    $house = new House();

    if(isset($_POST)){
        $house -> name = isset($_POST['name']) ? $_POST['name'] : missingData('name');
        $house -> location = isset($_POST['location']) ? $_POST['location'] : missingData('location');
        $house -> rent = isset($_POST['rent']) ? $_POST['rent'] : missingData('rent');
        $house -> vacancy = isset($_POST['vacancy']) ? $_POST['vacancy'] : missingData('vacancy');
        $house -> owner_contact = isset($_POST['owner_contact']) ? $_POST['owner_contact'] : missingData('owner_contact');
        $house -> type = isset($_POST['type']) ? $_POST['type'] : missingData('type');

        if($house -> addHouse() == '0'){
            http_response_code(501);
            die();
        }
        http_response_code(200);
        echo 'House added.';
    }

    function missingData($data){
        echo "Missing " . $data;
        http_response_code(500);
        die();
    }
?>