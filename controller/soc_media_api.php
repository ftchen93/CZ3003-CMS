<?php

include_once MODEL_PATH . "api_details.php";

function postToFacebook($message, $caption = null, $description = null, $link = null, $picture = null) {
    global $fb_accesstoken, $fb_pageid;

    /**
     * caption      - Link caption
     * description  - Link description
     * link         - Link url
     * picture      - Link picture
     */
//    $data['picture'] = "http://www.example.com/image.jpg";
//    $data['description'] = "Description";
//    $data['link'] = "http://www.example.com/";
//    $data['caption'] = "Caption";
//    $data['message'] = "Your message";
    $data = array(
        "picture" => $picture,
        "link" => $link,
        "message" => $message,
        "caption" => $caption,
        "description" => $description,
        "access_token" => $fb_accesstoken
    );
    $url = "https://graph.facebook.com/$fb_pageid/feed";
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