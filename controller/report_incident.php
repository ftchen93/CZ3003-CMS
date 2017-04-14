<?php

$controller_ok = true;
include_once MODEL_PATH . "api_details.php";
include_once MODEL_PATH . "TrafficIncident.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["inc_type"]) && isset($_POST["inc_pos"]) && isset($_POST["inc_msg"])) {
        $inc_type = $_POST["inc_type"];
        $inc_pos = $_POST["inc_pos"];
        $inc_msg = $_POST["inc_msg"];
        $inc_agency = isset($_POST["inc_agency"]) ? $_POST["inc_agency"] : null;
        if ($inc_type != "" && $inc_pos != "" && $inc_msg != "") {
            $inc_pos_arr = explode(";", $inc_pos);
//            $inc_msg = date('(j/n)H:i ', time()) . $inc_msg;
            $trafficInc = new TrafficIncident(-1, $inc_type, floatval($inc_pos_arr[0]), floatval($inc_pos_arr[1]), $inc_msg);
            if ($trafficInc->saveIncident()) {
                $_SESSION["message"] = "1;;Thank you for reporting the incident!";
                header("Location: index.php?route=home");
                exit;
            } else {
                $message = "0;;Unable to save incident properly.";
            }
        }
        else
            $message = "0;;Empty arguments.";
    }
    else
        $message = "0;;Missing arguments.";
}

?>