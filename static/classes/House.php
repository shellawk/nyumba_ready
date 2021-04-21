<?php
    include_once(realpath(dirname(__DIR__))."/api/dbconnect.php");

    class House{
        public $conn;
        public $house_id;
        public $name;
        public $location;
        public $vacancy;
        public $owner_contact;
        public $type;
        public $rent;
        public $pic_url;

        public function __construct(){
            global $conn;
            $this -> conn = $conn;
        }
        public function getHouseById(){
            $sql = "SELECT * FROM houses WHERE house_id=:house_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(':house_id', $this -> house_id);

            try{
                $stmt -> execute();
                $house = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($house != false){
                    return json_encode($house);
                }else{
                    return 0;
                }
            }catch(PDOException $e){
                echo "ERROR:::" . $e -> getMessage();
                return 0;
            }
        }
        public function getAllHouseId(){
            $sql = "SELECT house_id FROM houses";
            $stmt = $this -> conn -> prepare($sql);

            try{
                $stmt -> execute();
                $count = 0;
                $houses = array();
                while(true){
                    $data = $stmt -> fetch(PDO::FETCH_ASSOC);
                    if($data != ''){
                        //print_r($data);
                        $houses[$count] = $data['house_id'];
                        $count += 1;
                        $data = '';
                    }else{
                        break;
                    }
                }
                return $houses;
            }catch(PDOException $e){
                echo "ERROR:::" . $e -> getMessage();
                return 0;
            }
        }
        public function addHouse(){
            $this -> house_id = uniqid();
            $sql = "INSERT INTO houses (`house_id`, `name`, `location`, `rent`, `vacancy`, `owner_contact`, `type`) VALUES(:house_id, :name, :location, :rent, :vacancy, :owner_contact, :type)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":house_id", $this -> house_id);
            $stmt -> bindParam(":name", $this -> name);
            $stmt -> bindParam(":location", $this -> location);
            $stmt -> bindParam(":rent", $this -> rent);
            $stmt -> bindParam(":vacancy", $this -> vacancy);
            $stmt -> bindParam(":owner_contact", $this -> owner_contact);
            $stmt -> bindParam(":type", $this -> type);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOExceptio $e){
                echo "ERROR::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
        public function removeHouse(){
            $sql = "DELETE FROM houses WHERE house_id=:house_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindParam(":house_id", $this -> house_id);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                echo "ERROR:::::::::::::" . $e -> getMessage();
            }
        }
        public function updatePic(){
            $pic_url = json_decode(json_decode($this -> getHouseById()) -> pic_url);
            if(count($pic_url) == 0){
                $pic_url = array($this -> pic_url);
            }else{
                $pic_url[count($pic_url)] = $this -> pic_url;
            }
            $this -> pic_url = json_encode($pic_url);

            $sql = "UPDATE houses SET pic_url=:pic_url WHERE house_id=:house_id";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bindparam(":pic_url", $this -> pic_url);
            $stmt -> bindParam(":house_id", $this -> house_id);

            try{
                $stmt -> execute();
                return 1;
            }catch(PDOException $e){
                echo "ERROR::::::::::::::" . $e -> getMessage();
                return 0;
            }
        }
    }

?>