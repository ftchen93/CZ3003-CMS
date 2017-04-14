<?php

$controller_ok = true;
include_once MODEL_PATH . "api_details.php";
include_once MODEL_PATH . "TrafficIncident.php";
include_once CONTROL_PATH . "soc_media_api.php";
include_once CONTROL_PATH . "sms_api.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["inc_type"]) && isset($_POST["inc_pos"]) && isset($_POST["inc_msg"])) {
        $inc_type = $_POST["inc_type"];
        $inc_pos = $_POST["inc_pos"];
        $inc_msg = $_POST["inc_msg"];
        $inc_agency = isset($_POST["inc_agency"]) ? $_POST["inc_agency"] : null;
		
		$call_fire = false;
        $call_am = false;
        $call_eva = false;
        foreach($inc_agency as $field){
            switch($field){
                case 'Ambulance':
                    $call_am = true;
                    break;
                case 'FireFighting':
                    $call_fire  = true;
                    break;
                case 'Evacuation':
                    $call_eva = true;
                    break;
            }
        }
        if ($inc_type != "" && $inc_pos != "" && $inc_msg != "") {
            $inc_pos_arr = explode(";", $inc_pos);
            $inc_time = date_create();
//            $inc_msg = date('(j/n)H:i ', time()) . $inc_msg;
            $trafficInc = new TrafficIncident(-1, $inc_type, floatval($inc_pos_arr[0]), floatval($inc_pos_arr[1]), $inc_msg, IncidentStatus::APPROVED, $inc_time);
            if ($trafficInc->saveIncident()) {
                $msgToPost = "Incident #" . $trafficInc->getId() . "\n\n\n" .
                    $trafficInc->getReportTime()->format('(j/n)H:i - ') .
                    $trafficInc->getType() . "\n\n\n" . $trafficInc->getMsg();
                postToFacebook($msgToPost);
				$smsMsg = "\r\nLat:".$trafficInc->getLat()."\r\nLng:".$trafficInc->getLng()."\r\nSummary:\r\n".$msgToPost;
				if($call_am)
					sendSms('+6594893944',"Emergency Report : (Emergency Ambulance)".$smsMsg);
				if($call_fire)
					sendSms('+6594893944',"Emergency Report : (Fire-Fighting)".$smsMsg);
				if($call_eva)
					sendSms('+6594893944',"Emergency Report : (Rescue and Evacuation)".$smsMsg);
				
                $_SESSION["message"] = "1;;Incident created successfully!";
                header("Location: index.php?route=view_traffic");
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