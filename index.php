<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/index.css">
    <link rel="stylesheet" href="static/css/navbar.css">
    <link rel="stylesheet" href="static/css/head.css">
    <link rel="stylesheet" href="static/css/login.css">
    <link rel="stylesheet" href="static/css/profile.css">
    <link rel="stylesheet" href="static/css/profile.css">
    <link rel="stylesheet" href="static/css/home.css">
    <title>NYUMBA READY</title>
</head>
<body>
    <div id="header">
        <?php include_once('head.php');?>
        <?php
            if(isset($_COOKIE['token'])){
                include_once('navbar_user.php');
            }else{
                include_once('navbar_guest.php');
            }
        ?>
    </div>
    <div id="main"></div>
    <div id="footer">
        <?php include_once('footer.php');?>
    </div>
    <script src="static/js/script.js"></script>
</body>
</html>