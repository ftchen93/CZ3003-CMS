<?php

include_once MODEL_PATH . "api_details.php";
include_once CONTROL_PATH . "apcu_cache.php";

if (!isset($get_traffic_api)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['service_type'])) {
            $service_type = $_POST['service_type'];
            if ($service_type == "traffic") {
                echo json_encode(array(
                    "status" => "success",
                    "content" => json_encode(fetchTrafficIncidents())
                ));
            } else {
                echo json_encode(array(
                    "status" => "error",
                    "text" => "Invalid service type request!"
                ));
            }
        }
        exit;
    } else {
        if (isset($_GET["called_by_timer"]) && $_GET["called_by_timer"] == "yes") {
            fetchTrafficIncidents(true);
            echo "Traffic OK";
            exit;
        } else {
            error_404();
        }
    }
}

function fetchTrafficIncidents($fetchNew = false) {
    if ($fetchNew) {
        $ret_arr = array();
        global $mytransport_acckey;
        $traffic_url = "http://datamall2.mytransport.sg/ltaodataservice/TrafficIncidents";
        $context = stream_context_create(
            array(
                'http' => array(
                    'method' => "GET",
                    'header' => "AccountKey: $mytransport_acckey"
//                        "Cookie: foo=bar\r\n" .
//                        "User-agent: BROWSER-DESCRIPTION-HERE\r\n"
                )
            )
        );

        $count = 0;
        while (true) {
            // Open the file using the HTTP headers set above
            $url = $traffic_url;
            if ($count > 0)
                $url .= "?\$skip=" . $count;
            $contents = file_get_contents($url, false, $context);
            $cont_arr = json_decode($contents, true);
            $ret_arr = array_merge($ret_arr, $cont_arr["value"]);
            if (count($cont_arr["value"]) < 50)
                break;
            $count += 50;
        }
        saveTrafficIncidents($ret_arr);
        return $ret_arr;
    }
    else {
        include_once MODEL_PATH . "TrafficIncident.php";
        $ret_arr = getTrafficIncidents();
        $allInc = TrafficIncident::retrieveAll(IncidentStatus::APPROVED);
        if (count($allInc)) {
            foreach ($allInc as $trafInc) {
                $ret_arr[] = array(
                    "Type" => $trafInc->getType(),
                    "Latitude" => $trafInc->getLat(),
                    "Longitude" => $trafInc->getLng(),
                    "Message" => $trafInc->getReportTime()->format('(j/n)H:i ') . $trafInc->getMsg()
                );
            }
        }
        return $ret_arr;
    }
}


?>
