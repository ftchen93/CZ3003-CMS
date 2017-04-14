<?php

$controller_ok = true;

include_once MODEL_PATH . "TrafficIncident.php";
include_once CONTROL_PATH . "soc_media_api.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deactivate_count = 0;

    foreach($_POST as $key => $value) {
        $incident = $value;
        $deactivate = false;
        foreach($incident as $field){
            switch($field){
                case 'Deactivate':
                    $deactivate = true;
                    break;
            }
        }

        if($deactivate){
            $inc_to_deact = TrafficIncident::getIncidentByID($key);
            if ($inc_to_deact != null) {
                $inc_to_deact->setStatus(IncidentStatus::DEACTIVATED);
                $inc_to_deact->updateStatus();
                $msgToPost = "***DEACTIVATED***\n\n\nIncident #" . $inc_to_deact->getId() . "\n\n\n" .
                    $inc_to_deact->getReportTime()->format('(j/n)H:i - ') .
                    $inc_to_deact->getType() . "\n\n\n" . $inc_to_deact->getMsg();
                postToFacebook($msgToPost);

                $deactivate_count++;
            }
        }
    }

    $_SESSION["message"] = "1;;".$deactivate_count." incident(s) deactivated!";
    header("Location: index.php?route=deactivate_incident");
    exit;
} else {
    $records = TrafficIncident::retrieveAll(IncidentStatus::APPROVED);
    $approved_inc = array();
    $now = date_create();
    for($i=0 ;$i<count($records); $i++){
        $incident = $records[$i];
//        $interval = date_diff($incident->getReportTime(), $now);
//        if(($interval->days * 24) + $interval->h > 24)
//            continue;

        $approved_inc[] = array(
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