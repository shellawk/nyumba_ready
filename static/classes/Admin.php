<?php
    include_once(realpath(dirname(__DIR__))."/api/dbconnect.php");

    class Admin{
        public $conn;
        public $admin_id;
        public $username;
        public $password;

        public function __construct(){
            global $conn;
            $this -> conn = $conn;
        }
        public function getAdminId(){
            $this -> password = md5(md5($this -> password));
            $sql = "SELECT admin_id FROM admin WHERE username=:username AND password=:password";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":username", $this -> username);
            $stmt -> bindParam("password", $this -> password);
            //print_r("...........$this -> password.............");

            try{
                $stmt -> execute();
                $result = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($result == false){
                    return 0;
                }
                return $result['admin_id'];
            }catch(PDOException $e){
                echo "ERROR:::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function checkAdminId(){
            $sql = "SELECT * FROM admin WHERE admin_id=:admin_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":admin_id", $this -> admin_id);

            try{
                $stmt -> execute();
                $result = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($result == false){
                    return 0;
                }
                return 1;
            }catch(PDOException $e){
                echo "ERROR:::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
    }
?>