<?php
    $db_server = 'localhost:3306';
    $db_username = 'root';
    $password = '';
    $db_schema = 'ekeja';

    try {
        $conn = new PDO("mysql:host=$db_server;dbname=$db_schema", $db_username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
?>