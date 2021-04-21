<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/User.php');
    $user = new User();
    if(isset($_POST)){
        $email = isset($_POST['email']) ? $_POST['email'] : missingField('Email');
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : missingField('First Name');
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : missingField('Last Name');
        $password = isset($_POST['password']) ? $_POST['password'] : missingField('Password');

        $user -> email = $email;
        $user -> firstname = $firstname;
        $user -> lastname = $lastname;
        $user -> password = $password;

        if($user -> getUserByEmail() != '0'){
            echo "User Exists";
            die();
        }else{
            if($user -> createUser() == '0'){
                echo 'Error inserting data';
            }
        }
    }
    function missingField($field){
        echo $field;
        die();
    }
?>