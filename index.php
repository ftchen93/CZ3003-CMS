<?php
//if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
//    $url = 'https://' . $_SERVER['HTTP_HOST']
//        . $_SERVER['REQUEST_URI'];
//
//    header('Location: ' . $url);
//    exit;
//}

if (session_status() == PHP_SESSION_NONE)
    session_start();

include_once "controller/preproc.php";

if (file_exists($use_template))
    include_once $use_template;

?>
