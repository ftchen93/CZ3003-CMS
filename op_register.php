<?php

$controller_ok = true;
include_once CONTROL_PATH . "User.php";
include_once MODEL_PATH . "User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["user_name"]) && isset($_POST["user_pwd"]))
    {
        $user_name = $_POST["user_name"];
        $userEnt = new User($_POST["user_name"], $_POST["user_pwd"]);
        if ($userEnt->isUserExist()) {
            $message = "0;;Username already exists!";
        } else {
            if ($userEnt->createAccount()) {
                $_SESSION["message"] = "1;;Hi $user_name, thank you for registering!";
                header("Location: index.php?route=op_login");
                exit;
            } else
                $message = "0;;Failed to register account!";
        }
    }
    else
        $message = "0;;Invalid POST operation!!";
}

?>