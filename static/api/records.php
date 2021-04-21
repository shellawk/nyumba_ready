<?php
    include_once(realpath(dirname(__DIR__)) . "/classes/User.php");
    include_once(realpath(dirname(__DIR__)) . "/classes/House.php");
    include_once(realpath(dirname(__DIR__)) . "/classes/Book.php");

    $book = new Book();
    $user = new User();
    $house = new House();

    $records = array();
    $all_record_id = $book -> getAllReference();
    
    foreach($all_record_id as $ref){
        $book -> pesapal_merchant_reference = $ref;
        $record = json_decode($book -> getBookRecordByRef());
        $house -> house_id = $record -> house_id;
        $user -> user_id = $record -> user_id;

        $each_record['house'] = json_decode($house -> getHouseById()) -> name;
        $each_record['email'] = json_decode($user -> getUserById()) -> email;
        $each_record['amount'] = $record -> amount;
        $each_record['status'] = $record -> status == '0' ? 'Pending' : 'Complete';
        $each_record['ref'] = $ref;

        $records[count($records)] = $each_record;
    }
    $no_of_records = count($records);

?>