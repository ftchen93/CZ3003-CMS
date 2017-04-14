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
        #weather-cont-div {
            position: relative;
            -ms-zoom: 0.75;
            -moz-transform: scale(0.75);
            -moz-transform-origin: top left;
            -o-transform: scale(0.75);
            -o-transform-origin: top left;
            -webkit-transform: scale(0.75);
            -webkit-transform-origin: top left;
            display: inline-block;
            margin-right: -100px;
            cursor: pointer;
        }
        #weather-frame {
            width: 600px;
            height: 400px;
        }
        #weather-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 3;
        }
        #traffic-cont-div {
            position: relative;
            /*-ms-zoom: 0.75;*/
            -moz-transform: scale(0.75);
            -moz-transform-origin: top left;
            -o-transform: scale(0.75);
            -o-transform-origin: top left;
            -webkit-transform: scale(0.75);
            -webkit-transform-origin: top left;
            display: inline-block;
            margin-right: -150px;
            cursor: pointer;
        }
        #traffic-frame {
            width: 600px;
            height: 400px;
        }
        #traffic-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 3;
        }
    </style>
    <?php
}

function body_extra()
{
    ?>
    <div id="main-cont-div">
        <div>
            <h1>Home</h1>
        </div>
        <br/>
        <div id="weather-cont-div">
            <iframe id="weather-frame" src="index.php?route=view_weather&blank_template=y" scrolling="no" iframe_zoom="0.8"></iframe>
            <div id="weather-overlay" class="noselect"></div>
        </div>
        <div id="traffic-cont-div">
            <iframe id="traffic-frame" src="index.php?route=view_traffic&blank_template=y" scrolling="no"></iframe>
            <div id="traffic-overlay" class="noselect"></div>
        </div>
    </div>
    <?php
}

function body_js()
{
    ?>
    <script type="text/javascript">
        // To get the center of the traffic map
//        var center = document.getElementById("traffic-frame").contentWindow.map.getCenter();
        $("#weather-overlay").on("click", function() {
            window.location.href = "index.php?route=view_weather";
        });
        $("#traffic-overlay").on("click", function() {
            window.location.href = "index.php?route=view_traffic";
        });
    </script>
    <?php
}
?>