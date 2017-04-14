<?php

if (!apcu_exists("test")) {
    apcu_add("test", array(
        "this" => "is",
        "a" => "test"
    ));
}

?>