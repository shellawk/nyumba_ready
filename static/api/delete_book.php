<?php
    include_once(realpath(dirname(__DIR__)) . '/classes/Book.php');
    $book = new Book();

    $pesapal_merchant_reference = isset($_POST['reference']) ? $_POST['reference'] : die(http_response_code(403));

    $book -> pesapal_merchant_reference = $pesapal_merchant_reference;
    if($book -> deleteBookRecord() == '0'){
        echo "Internal server error";
        die(http_response_code(501));
    };
    die(http_response_code(200));
?>