<?php

include_once MODEL_PATH . "api_details.php";

function sendSms($number, $message) {
    global $bulk_id, $bulk_pwd;
	
    $data = array(
        "username" => $bulk_id,
        "password" => $bulk_pwd,
        "message" => $message,
        "want_report" => "1",
        "msisdn" => $number
    );
    $url = "https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0";
    $context = stream_context_create(
        array(
            'http' => array(
                'method' => "POST",
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data)
            )
        )
    );
    $result = file_get_contents($url, false, $context);
//    error_log(print_r($result));
}



?>