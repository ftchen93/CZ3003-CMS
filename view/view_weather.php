<?php

function head_extra()
{
    global $blank_template;
    ?>
    <title>View Weather</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">

        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #title-h1 {
            font-weight: bold;
            -webkit-margin-before: 0.67em;
            -webkit-margin-after: 0.67em;
            -webkit-margin-start: 0px;
            -webkit-margin-end: 0px;
        }
        #map-holder-div {

            <?php
            if (isset($blank_template)) {
                echo 'height: 400px;';
                echo 'width: 600px;';
            }
            else {
                echo 'height: 600px;';
                echo 'width: 1200px;';
            }
            ?>
            position:relative;
            display: inline-block;
            border: 1px solid black;
        }
        #map-holder-div > div{
            position:absolute;
            top:0;
            left:0;
            height:100%;
            width:100%;
        }
    </style>
    <?php
}

function body_extra()
{
    ?>
    <div id="main-cont-div">
        <div>
            <h1 id="title-h1">View Weather</h1>
        </div>
        <br/>
        <div id="map-holder-div">
            <div id="map">
            </div>
            <div id="pane">
            </div>
        </div>
    </div>
    <?php
}

function body_js()
{
    global $google_apikey, $blank_template;
    ?>
    <script type="text/javascript" >
        var map = null;
        var infoWin = null;
//        var singapore = {lat: 1.3521, lng: 103.8198};
        var singapore = {lat: 1.3618331209085577, lng: 103.8156509399414};

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                <?php
                if (isset($blank_template))
                    echo 'zoom: 11,';
                else
                    echo 'zoom: 12,';
                ?>
                center: singapore
            });
            infoWin = new google.maps.InfoWindow({
                content: "No contents"
            });
            getWeatherReport();
        }

        function getWeatherReport() {
            $.ajax({
                type: "POST",
                url: "index.php?route=get_weather_api",
                data: {
                    "service_type": "weather",
                    "request": "24hr"
                },
                dataType: 'json',
                cache: false,
                success: function (data, textStatus, jqXHR) {
                    parser = new DOMParser();
                    xmlDoc = parser.parseFromString(data.content,"text/xml");
                    var relevantPart;

                    var currentDate = new Date();
                    var hour = currentDate.getHours();
                    if(hour<6||hour>=18)
                        relevantPart = xmlDoc.getElementsByTagName("night")[0];
                    else if(hour<12)
                        relevantPart = xmlDoc.getElementsByTagName("morn")[0];
                    else
                        relevantPart = xmlDoc.getElementsByTagName("afternoon")[0];

                    for(var i=0;i<relevantPart.childNodes.length;i++){
                        var node = relevantPart.childNodes[i];
                        if(node.tagName=='timePeriod')continue;
                        $("#pane").append(createWeatherLabel(node.tagName,node.childNodes[0].nodeValue));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }

        function createWeatherLabel(region,weather){
            var weatherLabel = document.createElement("img");
            var weatherName = getWeatherName(weather);
            var offset = getRegionLocation(region);

            weatherLabel.style.position = "absolute";
            weatherLabel.style.top = offset[0];
            weatherLabel.style.left = offset[1];
            weatherLabel.style.width = '20%';
            weatherLabel.style.height = '20%';
            weatherLabel.style.cursor = 'pointer';
            weatherLabel.alt = weatherName;
            weatherLabel.src = 'image/weather/'+weather+".png";
            $(weatherLabel).attr("title","");
            $(weatherLabel).attr("data-original-title",weatherName);
            $(weatherLabel).attr("data-placement",weatherLabel.style.top=="0%"?"bottom":"top");
            $(weatherLabel).attr("data-toggle", "tooltip");
            $(weatherLabel).tooltip();
            weatherLabel.onclick = function(){
                window.open("index.php?route=view_weather_info&region="+region);
            };
            return weatherLabel;
        }

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
            }
        }

        function getRegionLocation(regionName){
            switch(regionName){
                case "wxeast": return ["40%","72%"];
                case "wxwest": return ["40%","8%"];
                case "wxnorth": return ["8%","40%"];
                case "wxsouth": return ["72%","40%"];
                case "wxcentral": return ["40%","40%"];
            }
        }
//        function init(){
//
//            initMap();
//            $.ajax({
//                type: "GET",
//                url: "weather_api.php",
//                data: {request:'24hour'}
//            }).done(function( msg ) {
//                parser = new DOMParser();
//                xmlDoc = parser.parseFromString(msg,"text/xml");
//                var relevantPart;
//
//                var currentDate = new Date();
//                var hour = currentDate.getHours();
//                if(hour<6||hour>=18)
//                    relevantPart = xmlDoc.getElementsByTagName("night")[0];
//                else if(hour<12)
//                    relevantPart = xmlDoc.getElementsByTagName("morn")[0];
//                else
//                    relevantPart = xmlDoc.getElementsByTagName("afternoon")[0];
//
//                for(var i=0;i<relevantPart.childNodes.length;i++){
//                    var node = relevantPart.childNodes[i];
//                    if(node.tagName=='timePeriod')continue;
//                    $("#pane").append(createWeatherLabel(node.tagName,node.childNodes[0].nodeValue));
//                }
//            }).fail(function(msg) {
//                alert( "Error : "+msg );
//            });
//
//        };
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_apikey; ?>&callback=initMap">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
}
?>