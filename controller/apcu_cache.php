<?php

function saveTrafficIncidents($trafficIncidents) {
    if (apcu_exists("traffic")) {
        apcu_store("traffic", $trafficIncidents);
    } else {
        apcu_add("traffic", $trafficIncidents);
    }
}

function saveWeatherReport($weatherReport) {
    if (apcu_exists("weather")) {
        apcu_store("weather", $weatherReport);
    } else {
        apcu_add("weather", $weatherReport);
    }
}

function getTrafficIncidents() {
    if (apcu_exists("traffic")) {
        return apcu_fetch("traffic");
    }
    return null;
}

function getWeatherReport() {
    if (apcu_exists("weather")) {
        return apcu_fetch("weather");
    }
    return null;
}

?>