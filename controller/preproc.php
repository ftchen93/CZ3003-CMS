<?php

// Define paths
define("CONTROL_PATH", "controller/");
define("MODEL_PATH", "model/");
define("VIEW_PATH", "view/");
define("TEMPLATE_PATH", "view/template/");
define("LOGS_PATH", "log/");
define("TMP_PATH", "tmp/");
define("EXTLIB_PATH", "extlib/");

date_default_timezone_set('ASIA/Singapore');

// Error reporting
ini_set("log_errors", 1);
ini_set('error_reporting', E_ALL);
ini_set("error_log", "log/php-error.log");

$use_template = TEMPLATE_PATH . "default.php";

$filename = "";

// Process page name requested
if (isset($_GET["route"]) && $_GET["route"] !== "") {
    $filename = $_GET["route"];
    $filename = basename($filename, ".php");
} else {
    header("Location: index.php?route=home");
    exit;
}

// Process controller to load into index.php
$filename = $filename . ".php";
if (file_exists(CONTROL_PATH . $filename))
    include_once CONTROL_PATH . $filename;
else
    $controller_ok = true;

// If controller processing is ok, try to load view
if (isset($controller_ok)) {
    if (file_exists(VIEW_PATH . $filename))
        include_once VIEW_PATH . $filename;
    else {
        // View not found, invalid page, throw 404 error
        error_404();
    }
} else
    error_404();

// Format message to show (if any)
if (isset($message))
    $message = explode(";;", $message);
else if (isset($_SESSION["message"])) {
    $message = explode(";;", $_SESSION["message"]);
    unset($_SESSION["message"]);
}

// Template page functions
function get_header_extra() {
    if (function_exists("head_extra"))
        head_extra();
}

function get_body_extra() {
    if (function_exists("body_extra"))
        body_extra();
}

function get_body_js() {
    if (function_exists("body_js"))
        body_js();
}

// Authentication methods
function is_logged_in() {
    return (isset($_SESSION["user_name"]) && isset($_SESSION["logged_in"]));
}

function require_log_in() {
    if (!is_logged_in()) {
        header("Location: index.php");
        exit;
    }
}

function fail_log_in() {
    if (!is_logged_in()) {
        error_404();
    }
}

function error_404() {
    header('HTTP/1.1 404 Not Found'); //This may be put inside err.php instead
//        $_GET['e'] = 404; //Set the variable for the error code (you cannot have a
//        // querystring in an include directive).
    include('view/error404.php');
    exit;
}

?>