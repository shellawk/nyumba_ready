<?php
    include_once(realpath(dirname(__DIR__))."/api/dbconnect.php");
    //use PDO, PDOException;

    interface UserStructure {
        public function createUser();

    }
    class User implements UserStructure{
        public $conn;
        public $user_id;
        public $firstname;
        public $lastname;
        public $password;
        public $pic_url;
        public $email;

        public function __construct(){
            global $conn;
            $this->conn = $conn;
        }

        public function createUser(){
            $this -> user_id = md5($this -> email . uniqid());
            $this -> password = md5($this -> password);
            $this -> firstname = strtoupper($this -> firstname);
            $this -> lastname = strtoupper($this -> lastname);

            $sql = "INSERT INTO users(`user_id`, `email`, `firstname`, `lastname`, `password`) VALUES (:user_id, :email, :firstname, :lastname, :password)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":user_id", $this -> user_id);
            $stmt -> bindParam(":firstname", $this -> firstname);
            $stmt -> bindParam(":lastname", $this -> lastname);
            $stmt -> bindParam("password", $this -> password);
            $stmt -> bindParam(":email", $this -> email);

                try{
                    $stmt -> execute();
                    return 1;
                } catch(PDOException $e){
                    //echo "ERROR::::::" . $e -> getMessage(); 
                    return 0;
                }

        }
        public function getUserById(){
            $sql = "SELECT * FROM users WHERE user_id=:user_id";
            $stmt = $this -> conn ->prepare($sql);
            $stmt -> bindParam(":user_id", $this -> user_id);

            try{
                $stmt -> execute();
                $user = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($user != false){
                    return json_encode($user);
                }else{
                    return 0;
                }
            } catch(PDOException $e){
                //echo "Error: " . $e -> getMessage();
                return 0;
            }
        }
        public function getUserByEmail(){
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $this -> conn ->prepare($sql);
            $stmt -> bindParam(":email", $this -> email);

            try{
                $stmt -> execute();
                $user = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($user != false){
                    return json_encode($user);
                }else{
                    return 0;
                }
            } catch(PDOException $e){
                //echo "Error: " . $e -> getMessage();
                return 0;
            }
        }
        public function updateUserInfo(){
            $user_info = json_decode($this -> getUserById());
            if($user_info == '0'){
                return 0;
            }
            $this -> password = isset($this -> password) ? md5($this -> password) : $user_info -> password;
            $this -> pic_url = isset($this -> pic_url) ? $this -> pic_url : $user_info -> pic_url;

            $sql = "UPDATE users SET password=:password, pic_url=:pic_url WHERE user_id=:user_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(':user_id', $this -> user_id);
            $stmt -> bindParam(":password", $this -> password);
            $stmt -> bindParam(":pic_url", $this -> pic_url);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                //echo "ERROR:::" . $e -> getMessage();
                return 0;
            }
        }
        public function getAllUserId(){
            $sql = "SELECT user_id FROM users";
            $stmt = $this -> conn -> prepare($sql);
            try{
                $stmt -> execute();
                $count = 0;
                $result = array();
                while(true){
                    $data = $stmt -> fetch(PDO::FETCH_ASSOC);
                    if($data != ''){
                        $result[$count] = $data['user_id'];
                        $count += 1;
                    }else{
                        break;
                    }
                }
                return $result;
            }catch(PDOException $e){
                echo "ERROR:::::::::" . $e -> getMessage();
                return 0;
            }
        }public function removeUser(){
            $sql = "DELETE FROM users WHERE user_id=:user_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":user_id", $this -> user_id);
            
            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                echo "ERROR::::::::::" . $e -> getMessage();
                return 0;
            }
        }
    }
?>