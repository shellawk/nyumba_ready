<?php
    include_once("./static/classes/User.php");
    $user = new User();

    $user -> user_id = isset($_COOKIE['token']) ? $_COOKIE['token'] : checkCookie();

    function checkCookie(){
        //echo 'no cookie';
        http_response_code(501);
        header("Location: ./");
        die();
    }
    if($user -> getUserById() != '0'){
        http_response_code(200);
        $data = json_decode($user -> getUserById());
        $user_info = array(
            "name" => $data -> firstname . " " . $data -> lastname,
            "email" => $data -> email,
            "image" => strlen($data -> pic_url) ? $data -> pic_url : 'pic.png'
        );
        $user_info['image'] = './static/images/users/' . $user_info['image'];
    }else{
        http_response_code(501);
        header("Location: ./");
        die();
    }
?>

<div id="profile-div">
    <div id="display">
        <img src="<?php echo $user_info['image'];?>" alt="Profile Pic">
        <p id="name"><?php echo $user_info['name'];?></p>
    </div>
    <div id="info">
        <table id="info-table">
            <tr>
                <td><label for="email">Email:</label></td>
                <td><?php echo $user_info['email'];?></td>
            </tr>
            <tr>
                <td colspan="2"><button id="edit-profile-btn" onclick="loadPage('edit_profile')">EDIT PROFILE</button></td>
            </tr>
        </table>
    </div>
</div>