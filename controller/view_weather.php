<?php

$controller_ok = true;
include_once MODEL_PATH . "api_details.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["blank_template"])) {
        $use_template = TEMPLATE_PATH . "blank.php";
        $blank_template = true;
    }
}

?>