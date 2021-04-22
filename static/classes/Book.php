<?php
    include_once(realpath(dirname(__DIR__))."/api/dbconnect.php");

    class Book{
        public $conn;
        public $pesapal_merchant_reference;
        public $user_id;
        public $house_id;
        public $amount;
        public $status;

        public function __construct(){
            global $conn;
            $this -> conn = $conn;
        }
        public function createBookRecord(){
            $this -> status = '0';
            $sql = "INSERT INTO book(`pesapal_merchant_reference`, `user_id`, `house_id`, `amount`, `status`) VALUES(:pesapal_merchant_reference, :user_id, :house_id, :amount, :status)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":pesapal_merchant_reference", $this -> pesapal_merchant_reference);
            $stmt -> bindParam(":user_id", $this -> user_id);
            $stmt -> bindParam(":house_id", $this -> house_id);
            $stmt -> bindParam(":amount", $this -> amount);
            $stmt -> bindParam(":status", $this -> status);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                echo "ERROR::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function getBookRecordByUserId(){
           $sql = "SELECT * FROM book WHERE user_id=:user_id";
           $stmt = $this -> conn -> prepare($sql);
           $stmt -> bindParam(":user_id", $this -> user_id);

           try{
               $stmt -> execute();
               $result = $stmt -> fetch(PDO::FETCH_ASSOC);
               if($result == false){
                   return 0;
               }
               return json_encode($result);
           }catch(PDOException $e){
               echo "ERROR::::::::::::::" . $e -> getMessage();
               return 0;
           }
        }
        public function getBookRecordByRef(){
            $sql = "SELECT * FROM book WHERE pesapal_merchant_reference=:pesapal_merchant_reference";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":pesapal_merchant_reference", $this -> pesapal_merchant_reference);
 
            try{
                $stmt -> execute();
                $result = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($result == false){
                    return 0;
                }
                return json_encode($result);
            }catch(PDOException $e){
                echo "ERROR::::::::::::::" . $e -> getMessage();
                return 0;
            }
         }
        public function deleteBookRecord(){
            $sql = "DELETE FROM book WHERE pesapal_merchant_reference=:pesapal_merchant_reference";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":pesapal_merchant_reference", $this -> pesapal_merchant_reference);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOEXception $e){
                echo "ERROR:::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function getAllReference(){
            $sql = "SELECT pesapal_merchant_reference FROM book";
            $stmt = $this -> conn -> prepare($sql);

            try{
                $stmt -> execute();
                $count = 0;
                $refs = array();
                while(true){
                    $data = $stmt -> fetch(PDO::FETCH_ASSOC);
                    if($data != ''){
                        //print_r($data);
                        $refs[$count] = $data['pesapal_merchant_reference'];
                        $count += 1;
                        $data = '';
                    }else{
                        break;
                    }
                }
                return $refs;
            }catch(PDOException $e){
                echo "ERROR::::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function deleteBookRecordByUser(){
            $sql = "DELETE FROM book WHERE user_id=:user_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":user_id", $this -> user_id);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOEXception $e){
                echo "ERROR:::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function deleteBookRecordByHouse(){
            $sql = "DELETE FROM book WHERE house_id=:house_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":house_id", $this -> house_id);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOEXception $e){
                echo "ERROR:::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
    }
?>