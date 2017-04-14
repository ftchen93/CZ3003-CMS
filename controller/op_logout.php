<?php

$controller_ok = true;

//error_log("Logout!");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["user_logout"])) {
//        error_log("Test");
        $message = logout();
    }
    else
        $message = "0;;Invalid POST operation!!";
}

function logout() {
    if (isset($_SESSION["user_name"])) {
//            $logout_user = $_SESSION["user_name"];
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_name"]);
        unset($_SESSION["logged_in"]);
        $_SESSION["message"] = "1;;Successfully logged out!";
        header("Location: index.php?route=home");
        exit;
//            return $logout_user;
    }
    return "0;;Logout failed!";
}

?>