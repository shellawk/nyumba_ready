<?php
    include_once(realpath(dirname(__DIR__))."/api/dbconnect.php");

    class Review{
        public $conn;
        public $review_id;
        public $user_id;
        public $content;
        public $new_user_id;

        public function __construct(){
            global $conn;
            $this -> conn = $conn;
        }

        public function createReview(){
            $this -> review_id = uniqid();
            
            $sql = "INSERT INTO reviews(`review_id`, `user_id`, `content`) VALUES (:review_id, :user_id, :content)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":review_id", $this -> review_id);
            $stmt -> bindParam(":user_id", $this -> user_id);
            $stmt -> bindParam(":content", $this -> content);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                echo "ERRROR:::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function getReviewById(){
            $sql = "SELECT * FROM reviews WHERE review_id=:review_id";
            $stmt =  $this -> conn -> prepare($sql);
            $stmt -> bindParam(":review_id", $this -> review_id);

            try{
                $stmt -> execute();
                $result = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($result != false){
                    return $result;
                }
                return 0;
            }catch(PDOException $e){
                echo "ERROR:::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function getAllReviewId(){
            $sql = "SELECT review_id FROM reviews";
            $stmt = $this -> conn -> prepare($sql);

            try{
                $stmt -> execute();
                $count = 0;
                $result = array();
                while(true){
                    $data = $stmt -> fetch(PDO::FETCH_ASSOC);
                    if($data != ''){
                        $result[$count] = $data['review_id'];
                        $count += 1;
                    }else{
                        break;
                    }
                }
                return $result;
            }catch(PDOException $e){
                echo "ERROR:::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function changeUserId(){
            $sql = "UPDATE reviews SET user_id=:new_user_id WHERE user_id=:user_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":new_user_id", $this -> new_user_id);
            $stmt -> bindParam(":user_id", $this -> user_id);
            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                return 0;
            }
        }
        public function removeReviewByUserId(){
            $sql = "DELETE FROM reviews WHERE user_id=:user_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":user_id", $this -> user_id);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                return 0;
            }
        }
    }
?>