<?php
    //show error reporting
    error_reporting(E_ALL);

    //set timezone
    date_default_timezone_set('Asia/Manila');

    //variabel for jwt
    $key = "example_key";
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60); // valid for 1 hour
    $issuer = "localhost/dimas/authlevel1";//remember this
?>