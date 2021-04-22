<?php include_once('check_cookie.php');?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>NYUMBA READY Admin</title>
</head>
<body>
    <div id="header">
        <div id="head">
            <h1>NYUMBA READY ADMIN</h1>
        </div>
        <div id="navbar">
            <?php
                if($logged_in == '1'){
                    include_once('navbar.php');
                }
            ?>
        </div>
    </div>
    <div id="main">
    <?php
                if($logged_in == '1'){
                    include_once('navbar.php');
                }else{
                    include_once('login.php');
                }
            ?>
    </div>
    <div id="footer"></div>
    <script src="<?php
        if($logged_in == '0'){
            echo './js/login.js';
        }else{
            echo './js/admin.js';
        }
    ?>"></script>
</body>
</html>