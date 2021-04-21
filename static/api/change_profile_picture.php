<?php
include_once(realpath(dirname(__DIR__)) . "/classes/User.php");
$user = new User();
$path_to_image = realpath(dirname(__DIR__)) . '/images/users/';
header("Location: ../../");

    if(isset($_COOKIE['token']) && isset($_FILES['image']) && isset($_POST)){
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $tmp_name = $image['tmp_name'];
        $image_size = $image['size'];

        if($image_size > 10485760){
            echo "Image size cannot exceed 10MB";
            http_response_code(501);
            die();
        }

        $image_extension = explode('.', $image_name);
        $image_extension = $image_extension[count($image_extension) -1];
        
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        if(!in_array($image_extension, $allowed_extensions)){
            echo "Upload PNG or JPEG file";
            http_response_code(501);
            die();
        }

        $image_upload_path = uniqid() . "." . $image_extension;
        $user -> pic_url = $image_upload_path;
        $image_upload_path = realpath(dirname(__DIR__)) . "/images/users/" . $image_upload_path;

        $user -> user_id = $_COOKIE['token'];
        if($user -> getUserById() == '0'){
            http_response_code(403);
            echo 'Not logged in';
            die();
        }else{
            $current_pic = json_decode($user -> getUserById()) -> pic_url;
            if(strlen($current_pic) > 8){
                system('rm ' . $path_to_image . $current_pic);
                //echo 'Unlicnk';
            }
        }
        if(!move_uploaded_file($tmp_name, $image_upload_path)){
            echo "Image not uploaded";
            http_response_code(501);
            die();
        }

        if($user -> updateUserInfo() == '0'){
            echo 'Database error';
            http_response_code(501);
        }
        http_response_code(200);
        //echo 'Success';
    }
    header("Location: ../../");


?>