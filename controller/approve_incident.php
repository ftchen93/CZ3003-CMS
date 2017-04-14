<?php

$controller_ok = true;
include_once MODEL_PATH . "TrafficIncident.php";
include_once CONTROL_PATH . "soc_media_api.php";
include_once CONTROL_PATH . "sms_api.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $approved_count = 0;
    foreach($_POST as $key => $value) {
        $incident = $value;
        $approve = false;
        $call_fire = false;
        $call_am = false;
        $call_eva = false;
        foreach($incident as $field){
            switch($field){
                case 'Approve':
                    $approve = true;
                    break;
                case 'Ambulance':
                    $call_am = true;
                    break;
                case 'FireFighting':
                    $call_fire = true;
                    break;
                case 'Evacuation':
                    $call_eva = true;
                    break;
            }
        }
        if($approve){
            $inc_to_approve = TrafficIncident::getIncidentByID($key);
            if ($inc_to_approve != null) {
                $inc_to_approve->setStatus(IncidentStatus::APPROVED);
                $inc_to_approve->updateStatus();
                $msgToPost = "Incident #" . $inc_to_approve->getId() . "\n\n\n" .
                    $inc_to_approve->getReportTime()->format('(j/n)H:i - ') .
                    $inc_to_approve->getType() . "\n\n\n" . $inc_to_approve->getMsg();
                postToFacebook($msgToPost);
				$smsMsg = "\r\nLat:".$inc_to_approve->getLat()."\r\nLng:".$inc_to_approve->getLng()."\r\nSummary:\r\n".$msgToPost;
				if($call_am)
					sendSms('+6594893944',"Emergency Report : (Emergency Ambulance)".$smsMsg);
				if($call_fire)
					sendSms('+6594893944',"Emergency Report : (Fire-Fighting)".$smsMsg);
				if($call_eva)
					sendSms('+6594893944',"Emergency Report : (Rescue and Evacuation)".$smsMsg);
                $approved_count++;
            }
        }
    }

    $_SESSION["message"] = "1;;".$approved_count." incident(s) approved!";
    header("Location: index.php?route=approve_incident");
    exit;
} else {
    $records = TrafficIncident::retrieveAll(IncidentStatus::PENDING);
    $pending_inc = array();
    $now = date_create();
    for($i=0 ;$i<count($records); $i++){
        $incident = $records[$i];
        $interval = date_diff($incident->getReportTime(), $now);
        if(($interval->days * 24) + $interval->h > 24)
            continue;

        $pending_inc[] = array(
            "id" => $incident->getId(),
            "type" => $incident->getType(),
            "time" => $incident->getReportTimeAsStr(),
            "lat" => $incident->getLat(),
            "lng" => $incident->getLng(),
            "msg" => $incident->getMsg()
        );
    }
}

?>