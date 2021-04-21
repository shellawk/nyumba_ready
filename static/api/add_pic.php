<?php
    include_once(realpath(dirname(__DIR__)) . "/classes/House.php");
    $house = new House();
    $path_to_image = realpath(dirname(__DIR__)) . '/images/houses/';
    
        if(isset($_FILES['image']) && isset($_POST['house_id'])){
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
            $house -> pic_url = $image_upload_path;
            $image_upload_path = realpath(dirname(__DIR__)) . "/images/houses/" . $image_upload_path;

            if(!move_uploaded_file($tmp_name, $image_upload_path)){
                echo("not uploaded");
                die();
            }
            $house -> house_id = $_POST['house_id'];
            $house -> updatePic();
        }
        header("Location: ../../admin");
?>