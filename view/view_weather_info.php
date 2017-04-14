<?php

function head_extra()
{
    ?>
    <title>View Weather Info</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #weather-info-div {
            display: inline-block;
            text-align: left;
        }
        #weather-info-tbl>*>*>*{
            border:1px solid black;
            padding: 5px;
        }
    </style>
    <?php
}

function body_extra()
{
    ?>
    <div id="main-cont-div">
        <div>
            <h1>View Weather Info</h1>
        </div>
        <br/>
        <div id="weather-info-div">
            <table id = "weather-info-tbl">
                <thead>
                    <tr>
                        <th>Area</th>
                        <th>Weather</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

function body_js()
{
    global $name;
    ?>
    <script type="text/javascript" >

        var areas = [
            <?php
            while(sizeof($name)>0){
                echo "'" . array_shift($name). "',";
            }
            ?>
            ""
        ];

        function getWeatherName(abbr){
            switch(abbr){
                case "BR": return "Mist";
                case "CL": return "Cloudy";
                case "DR": return "Drizzle";
                case "FA": return "Fair (Day)";
                case "FG": return "Fog";
                case "FN": return "Fair (Night)";
                case "FW": return "Fair & Warm";
                case "HG": return "Heavy Thundery Showers with Gusty Winds";
                case "HR": return "Heavy Rain";
                case "HS": return "Heavy Showers";
                case "HT": return "Heavy Thundery Showers";
                case "HZ": return "Hazy";
                case "LH": return "Slightly Hazy";
                case "LR": return "Light Rain";
                case "LS": return "Light Showers";
                case "OC": return "Overcast";
                case "PC": return "Partly Cloudy (Day)";
                case "PN": return "Partly Cloudy (Night)";
                case "PS": return "Passing Showers";
                case "RA": return "Moderate Rain";
                case "SH": return "Showers";
                case "SK": return "Strong Winds, Showers";
                case "SN": return "Snow";
                case "SR": return "Strong Winds, Rain";
                case "SS": return "Snow Showers";
                case "SU": return "Sunny";
                case "SW": return "Strong Winds";
                case "TL": return "Thundery Showers";
                case "WC": return "Windy, Cloudy";
                case "WD": return "Windy";
                case "WF": return "Windy, Fair";
                case "WR": return "Windy, Rain";
                case "WS": return "Windy, Showers";
                case "SU": return "Sunny";
            }
        }

        function getWeatherReport() {
            $.ajax({
                type: "POST",
                url: "index.php?route=get_weather_api",
                data: {
                    "service_type": "weather",
                    "request": "2hr"
                },
                dataType: 'json',
                cache: false,
                success: function (data, textStatus, jqXHR) {
                    parser = new DOMParser();
                    xmlDoc = parser.parseFromString(data.content,"text/xml");
                    console.log(xmlDoc);
                    var relevantPart = xmlDoc.getElementsByTagName("item")[0].getElementsByTagName("weatherForecast")[0];
                    for(var i=0;i<relevantPart.childNodes.length;i++){
                        var area = relevantPart.childNodes[i].getAttribute("name");
                        var forecast = relevantPart.childNodes[i].getAttribute("forecast");
                        if(areas.includes(area)){
                            $("#weather-info-tbl").find("tbody").append(
                                "<tr><td>"+area+"</td><td>"+getWeatherName(forecast)+"</td></tr>"
                            );
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }

        $(document).ready(function() {
            getWeatherReport();
        });
    </script>
    <?php
}
?>