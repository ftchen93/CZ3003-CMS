<?php

function head_extra()
{
    ?>
    <title>Home</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #map-holder-div {
            width: 1200px;
            height: 600px;
            position: relative;
            display: inline-block;
            border: 1px solid black;
        }
        #map {
            width: 100%;
            height: 100%;
        }
        /*#btn_update {*/
            /*position: absolute;*/
            /*top: 5px;*/
            /*right: 5px;*/
        /*}*/
        #btn-center {
            position: absolute;
            top: 5px;
            right: 5px;
        }
    </style>
    <?php
}

function body_extra()
{
    ?>
    <div id="main-cont-div">
        <div>
            <h1>View Traffic Incidents</h1>
        </div>
        <br/>
        <div id="map-holder-div">
            <div id="map"></div>
<!--            <input type="button" id="btn_update" value="Stop Update"/>-->
            <input type="button" id="btn-center" value="Center Map"/>
        </div>
    </div>
    <?php
}

function body_js()
{
    global $google_apikey, $all_incidents, $blank_template;
    ?>
    <script type="text/javascript">
        var map = null;
        var infoWin = null;
        var marker_arr = [];
        var type_arr = [];
        var singapore = {<?php
            if (isset($blank_template))
                echo 'lat: 1.292500533024804, lng: 104.02713775634766';
            else
                echo 'lat: 1.3618331209085577, lng: 103.8156509399414';
        ?>};

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
//                google.maps.event.addListener(map, 'click', function(event){
//                    var latitude = event.latLng.lat();
//                    var longitude = event.latLng.lng();
//                    console.log( latitude + ', ' + longitude );
//                });
        }

        function getColor(incident_type) {
            switch (incident_type) {
                case "Accident":
                    return "pink";
                case "Roadwork":
                    return "blue";
                case "Vehicle breakdown":
                    return "purple";
                case "Heavy Traffic":
                    return "orange";
                case "Road Block":
                    return "lightblue";
                default:
                    return "yellow";
            }
        }

        // for list of available map icons, see https://sites.google.com/site/gmapsdevelopment/
        function addMarkerToMap(json_arr) {
            var ele, marker, content;
            for (var i = 0; i < json_arr.length; i++) {
                ele = json_arr[i];
                if (type_arr.indexOf(ele.Type) == -1)
                    type_arr.push(ele.Type);
                marker = new google.maps.Marker({
                    position: {lat: ele.Latitude, lng: ele.Longitude},
                    map: map,
                    title: ele.Message,
                    icon: '//maps.google.com/mapfiles/ms/icons/' + getColor(ele.Type) + '.png'
                });
                content = '<div style="max-width:250px;">' +
                    '<h style="font-weight:bold; font-size:18px;">' + ele.Type + '</h>' +
                    '</br><p >' + ele.Message + '</p>' +
                    '</div>';
                google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
                    return function() {
                        infowindow.setContent(content);
                        infowindow.open(map,marker);
                    };
                })(marker,content,infoWin));
                marker_arr.push(marker);
//                    console.log(arr.value[i]);
            }
            console.log(type_arr);
            console.log("Total records: " + i);
            return i;
        }

        function getTrafficIncident() {
            $.ajax({
                type: "POST",
                url: "index.php?route=get_traffic_api",
                data: {"service_type": "traffic"},
                dataType: 'json',
                cache: false,
                success: function (data, textStatus, jqXHR) {
//                        console.log(data);
                    addMarkerToMap($.parseJSON(data.content));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }

        function clearMarkers() {
            for (var i = 0; i < marker_arr.length; i++) {
                marker_arr[i].setMap(null);
            }
            marker_arr.length = 0;
        }

        var timer = null;
        function updateTrafficIncident() {
            /* Clear @theTimer */
            if (timer != null)
                clearTimeout(timer);
            console.log("Timer start!");
            clearMarkers();
            getTrafficIncident();

            timer = setTimeout(function () {
                updateTrafficIncident();
            }, 25000);
        }

//        var is_updating = true;
//        $("#btn_update").on("click", function () {
//            if (is_updating) {
//                if (timer != null)
//                    clearTimeout(timer);
//                $("#btn_update").prop("value", "Start Update");
//            } else {
//                updateTrafficIncident();
//                $("#btn_update").prop("value", "Stop Update");
//            }
//            is_updating = !is_updating;
//        });
        $("#btn-center").on("click", function () {
            map.panTo(singapore);
            map.setZoom(12);
        });

        $(window).on("load", function () {
            <?php if (isset($all_incidents)) { ?>
            var test = <?php echo json_encode($all_incidents); ?>;
            addMarkerToMap(test);
            <?php } ?>
            <?php if (!isset($blank_template)) { ?>
            timer = setTimeout(function () {
                updateTrafficIncident();
            }, 25000);
            <?php } ?>
        });
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_apikey; ?>&callback=initMap">
    </script>
    <?php
}
?>