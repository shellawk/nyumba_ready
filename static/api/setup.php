<?php
    include_once('dbconnect.php');
    $tables = array(
        //"user" => "CREATE TABLE `users` ( `user_id` VARCHAR(50) NOT NULL, `email` VARCHAR(50) NOT NULL , `firstname` VARCHAR(100) NOT NULL , `lastname` VARCHAR(100) NOT NULL , `password` VARCHAR(100) NOT NULL , `pic_url` VARCHAR(50) NOT NULL, PRIMARY KEY(`user_id`)) ENGINE = InnoDB;",
        //"house" => "CREATE TABLE `houses` ( `house_id` VARCHAR(100) NOT NULL , `name` VARCHAR(50) NOT NULL, `location` VARCHAR(50) NOT NULL , `rent` INT(50) NOT NULL , `vacancy` INT(100) NOT NULL , `owner_contact` VARCHAR(50) NOT NULL , `type` VARCHAR(100) NOT NULL, `pic_url` VARCHAR(100) NOT NULL , PRIMARY KEY (`house_id`)) ENGINE = InnoDB;",
        //"reviews" => "CREATE TABLE `reviews` ( `review_id` VARCHAR(50) NOT NULL , `user_id` VARCHAR(50) NOT NULL , `content` TEXT NOT NULL , PRIMARY KEY (`review_id`)) ENGINE = InnoDB;",
        //"admin" => "CREATE TABLE `admin` ( `admin_id` VARCHAR(50) NOT NULL , `username` VARCHAR(50) NOT NULL , `password` VARCHAR(50) NOT NULL , PRIMARY KEY (`admin_id`)) ENGINE = InnoDB;",
        "book" => "CREATE TABLE `book` ( `pesapal_merchant_reference` VARCHAR(50) NOT NULL , `user_id` VARCHAR(50) NOT NULL , `house_id` VARCHAR(50) NOT NULL , `amount` INT(20) NOT NULL , `pesapal_transaction_tracking_id` VARCHAR(50) NOT NULL, `status` VARCHAR(50) NOT NULL , PRIMARY KEY (`pesapal_merchant_reference`)) ENGINE = InnoDB;"
    );
    function createTables(){
        global $tables, $conn;
        foreach($tables as $table => $sql){
            $stmt = $conn -> prepare($sql);

            try{
                $stmt -> execute();
                echo "CREATED TABLE " . $table . "\n";
                return true;
            } catch(PDOException $e){
                echo "Error: " . $e -> getMessage();
                return false;
            }
        }
    }
    createTables();
?>