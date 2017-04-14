<?php

$controller_ok = true;
include_once MODEL_PATH . "User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["user_name"]) && isset($_POST["user_pwd"])) {
        $user_name = $_POST["user_name"];
        $userEnt = new User($user_name, $_POST["user_pwd"]);
        if ($userEnt->verifyCredentials()) {
            $_SESSION["user_id"] = $userEnt->getUserid();
            $_SESSION["user_name"] = $userEnt->getUsername();
            $_SESSION["logged_in"] = true;
            $_SESSION["message"] = "1;;Hi $user_name, thank you for logging in!";
            header("Location: index.php?route=home");
            exit;
        }
        else
            $message = "0;;Invalid login details entered!";
    }
    else
        $message = "0;;Invalid POST operation!!";
}

?>