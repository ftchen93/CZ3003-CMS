<?php

function head_extra()
{
    ?>
    <title>Report Incident Form</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #report-inc-div {
            display: inline-block;
            text-align: left;
        }
        #report-inc-table .row-separator {
            height: 13px;
            width: 0;
        }
        #report-inc-table .col-separator {
            height: 0;
            width: 8px;
        }
        #report-inc-table td {
            vertical-align: middle;
        }
        #incident-msg {
            width: 100%;
        }
        #map-holder-div {
            width: 800px;
            height: 500px;
            position: relative;
            display: inline-block;
            border: 1px solid black;
        }
        #map {
            width: 100%;
            height: 100%;
        }
    </style>
    <?php
}

function body_extra()
{
    ?>
    <div id="main-cont-div">
        <div>
            <h1>Report Incident Form</h1>
        </div>
        <br/>
        <div id="report-inc-div">
            <form id="report-inc-form" action="index.php?route=report_incident" method="POST" >
                <table id="report-inc-table">
                    <tr>
                        <td>
                            Traffic Incident Type :
                        </td>
                        <td class="col-separator"></td>
                        <td>
                            <select id="incident-type" name="inc_type">
                                <option value=""></option>
                                <option value="Accident">Accident</option>
                                <option value="Road Works">Road Works</option>
                                <option value="Vehicle Breakdown">Vehicle Breakdown</option>
                                <option value="Weather">Weather</option>
                                <option value="Obstacle">Obstacle</option>
                                <option value="Road Block">Road Block</option>
                                <option value="Heavy Traffic">Heavy Traffic</option>
                                <option value="Misc.">Misc.</option>
                                <option value="Diversion">Diversion</option>
                                <option value="Unattended Vehicle">Unattended Vehicle</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="row-separator"></tr>
                    <tr>
                        <td>
                            Location :
                        </td>
                        <td class="col-separator"></td>
                        <td>
                            <div id="map-holder-div">
                                <div id="map"></div>
                                <input type="button" id="btn-center" value="Center Map"/>
                                <!--            <input type="button" id="btn_update" value="Stop Update"/>-->
                            </div>
                            <input type="hidden" id="incident-pos" name="inc_pos" />
                        </td>
                    </tr>
                    <tr class="row-separator"></tr>
                    <tr>
                        <td>
                            Message :
                        </td>
                        <td class="col-separator"></td>
                        <td>
                            <textarea id="incident-msg" rows="8" name="inc_msg"></textarea>
                        </td>
                    </tr>
                    <tr class="row-separator"></tr>
                    <tr>
                        <td colspan="2"></td>
                        <td><input type="button" id="btn-submit" value="Submit Form" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
}

function body_js()
{
    global $google_apikey;
    ?>
    <script type="text/javascript">
        var map = null;
        var infoWin = null;
        var singapore = {lat: 1.3618331209085577, lng: 103.8156509399414};
        var marker = null;
        var inc_pos = null;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: singapore
            });
            infoWin = new google.maps.InfoWindow({
                content: "No contents"
            });
            marker = new google.maps.Marker({
                position: singapore,
                map: map,
                draggable:true,
                title:"Drag me!"
            });
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                inc_pos = event.latLng;
            });
            google.maps.event.addListener(marker, 'dragend', function(event) {
                inc_pos = event.latLng;
            });
        }

        $("#btn-center").on("click", function () {
            map.panTo(singapore);
            map.setZoom(12);
        });

        function checkAllFields() {
            if (marker == null) {
                alert("Marker is missing! Please reload page and retry again.");
            }
            else if ($("#incident-type option:selected").val() == "") {
                var target = $("#incident-type");
                alert("Please select a type of incident!");
                $('html,body').animate({
                    scrollTop: target.offset().top - 50
                }, 300, function() {
                    target.focus();
                });
            }
            else if (inc_pos == null) {
                alert("Please indicate the position of the incident (by clicking on location or dragging marker to location on map)!");
                $('html,body').animate({
                    scrollTop: $("#map-holder-div").offset().top - 50
                }, 300);
            }
            else if ($("#incident-msg").val() == "") {
                var target = $("#incident-msg");
                alert("Please indicate the position of the incident (by clicking on location or dragging marker to location on map)!");
                $('html,body').animate({
                    scrollTop: target.offset().top - 50
                }, 300, function() {
                    target.focus();
                });
            }
            else {
                $("#incident-pos").val(inc_pos.lat() + ";" + inc_pos.lng());
                $("#report-inc-form").submit();
            }
        }

        $("#btn-submit").on("click", function () {
            checkAllFields();
        });
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_apikey; ?>&callback=initMap">
    </script>
    <?php
}
?>