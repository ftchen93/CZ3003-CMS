<?php

include_once MODEL_PATH . "api_details.php";
include_once CONTROL_PATH . "apcu_cache.php";

include_once MODEL_PATH . "TrafficIncident.php";

if (!isset($get_weather_api)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['service_type']) && isset($_POST['request'])) {
            $service_type = $_POST['service_type'];
            $request = $_POST['request'];
            if ($service_type == "weather") {
                echo json_encode(array(
                    "status" => "success",
                    "content" => fetchWeatherReport()[$request]
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
            fetchWeatherReport(true);
            echo "Weather OK";
            exit;
        }
//    else {
//        error_404();
//    }
    }
}

function fetchWeatherReport($fetchNew = true)
{
    if ($fetchNew) {
        global $nea_refkey;
        $weatherReport = array(
            "2hr" => file_get_contents('http://api.nea.gov.sg/api/WebAPI/?dataset=2hr_nowcast&keyref=' . $nea_refkey),
            "24hr" => file_get_contents('http://api.nea.gov.sg/api/WebAPI/?dataset=24hrs_forecast&keyref=781CF461BB6606AD80A87393DAFA402AA7ED82C02A27819B'),
//            "24hr" => file_get_contents('http://api.nea.gov.sg/api/WebAPI/?dataset=24hrs_forecast&keyref=781CF461BB6606AD80A87393DAFA402A77C7B8180415EF0F')
        );
        saveWeatherReport($weatherReport);
        return $weatherReport;
    }
    else {
        $weatherReport = getWeatherReport();
        return $weatherReport;
    }
}
//    if($requestType=='24hour'){
//        echo file_get_contents('http://api.nea.gov.sg/api/WebAPI/?dataset=24hrs_forecast&keyref=781CF461BB6606AD80A87393DAFA402A77C7B8180415EF0F');
//    }
//    else if($requestType=='2hour'){
//        echo file_get_contents('http://api.nea.gov.sg/api/WebAPI/?dataset=2hr_nowcast&keyref=781CF461BB6606AD80A87393DAFA402AA7ED82C02A27819B');
//    }

//echo file_get_contents('http://api.nea.gov.sg/api/WebAPI/?dataset=2hr_nowcast&keyref=781CF461BB6606AD80A87393DAFA402AA7ED82C02A27819B');
exit;

?>