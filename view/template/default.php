<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
        <link rel="icon" type="image/png" href="image/globe-icon.png" />
        <style type="text/css">
            html, body {
                margin: 0px;
                padding: 0px;
                font-family: "Helvetica Neue", Helvetica, "Liberation Sans", Arial, sans-serif;
				<?php
				if (is_logged_in())
					echo "min-width: 1350px;";
				else
					echo "min-width: 1200px;";
				?>
                background-color: #e6e6e6 !important;
            }
            form {
                margin: 0px;
            }
            input[type="text"], input[type="password"] {
                width: 170px;
            }
            .noselect {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            #temp-div {
                display: none;
                position: absolute;
                z-index: 99;
                top: 0px;
                left: 0px;
                width: 100%;
                background-color: #fffeb7;
                border-bottom: 1px solid #007ec8;
            <?php
            if (isset($message)) {
                if ($message[0] == "0")
                    echo "color: red;";
                else
                    echo "color: green;";
            }
            ?>
            }
            #temp-inner-div {
                display: inline-block;
                vertical-align: middle;
                width: 95%;
                padding: 10px 6px;
            }
            #hide-temp-div {
                display: inline-block;
                position: absolute;
                margin: auto;
                top: 0px;
                bottom: 0px;
                right: 3px;
                width: 25px;
                cursor: pointer;
            }
            #header-div {
                /*border: 1px solid black;*/
                width: 100%;
                height: 120px;
                /*line-height: 120px;*/
                display: table;
            }
            #cms-logo-div {
                border: 0 solid black;
                /*border-right-width: 1px;*/
                width: 240px;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }
            #cms-logo {
                width: 170px;
                display: inline-block;
                cursor: pointer;
            }
            .vertical-align {
                display: inline-block;
                width: 0px;
                height: 100%;
                /*border: 1px solid black;*/
                vertical-align: middle;
            }
            #header-rest-div {
                /*height: 50px;*/
                /*border: 1px solid black;*/
                display: table-cell;
                text-align: right;
                vertical-align: bottom;
            }
            #btn-op-login {
                display: inline-block;
                cursor: pointer;
                border: 1px inset olivedrab;
                padding: 10px;
                margin-bottom: 18px;
                margin-right: 18px;
            }
            #btn-op-logout {
                display: inline-block;
                cursor: pointer;
                border: 1px inset olivedrab;
                padding: 10px;
                margin-bottom: 18px;
                margin-right: 18px;
            }
            #menubar-div {
                height: 50px;
                border-width: 1px 0 1px 0;
                border-style: solid;
                border-color: black;
                text-align: center;
                white-space: nowrap;
                /*background-color: #8CC8F0;*/
                font-size: 0;
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #7892c2), color-stop(1, #8cc8f0));
                background:-moz-linear-gradient(top, #7892c2 5%, #8cc8f0 100%);
                background:-webkit-linear-gradient(top, #7892c2 5%, #8cc8f0 100%);
                background:-o-linear-gradient(top, #7892c2 5%, #8cc8f0 100%);
                background:-ms-linear-gradient(top, #7892c2 5%, #8cc8f0 100%);
                background:linear-gradient(to bottom, #7892c2 5%, #8cc8f0 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#7892c2', endColorstr='#8cc8f0',GradientType=0);
                background-color:#7892c2;
            }
            .menubar-button {
                display: inline-block;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                border: 0 solid black;
                border-right-width: 1px;
                height: 100%;
                line-height: 50px;
                padding-left: 20px;
                padding-right: 20px;
                font-size: 18px;
                /*border: 1px solid black;*/
            }
            .menubar-button:hover {
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #8cc8f0), color-stop(1, #7892c2));
                background:-moz-linear-gradient(top, #8cc8f0 5%, #7892c2 100%);
                background:-webkit-linear-gradient(top, #8cc8f0 5%, #7892c2 100%);
                background:-o-linear-gradient(top, #8cc8f0 5%, #7892c2 100%);
                background:-ms-linear-gradient(top, #8cc8f0 5%, #7892c2 100%);
                background:linear-gradient(to bottom, #8cc8f0 5%, #7892c2 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8cc8f0', endColorstr='#7892c2',GradientType=0);
                background-color:#8cc8f0;
            }
            .menubar-button:first-child {
                border-left: 1px solid black;
            }

            .button{
                display: inline-block;
                *display: inline;
                zoom: 1;
                padding: 6px 20px;
                margin: 0;
                cursor: pointer;
                border: 1px solid #bbb;
                overflow: visible;
                font: bold 13px arial, helvetica, sans-serif;
                text-decoration: none;
                white-space: nowrap;
                color: #555;
                background-color: #ddd;
                background-image: linear-gradient(top, rgba(255,255,255,1),
                rgba(255,255,255,0)),
                url(data:image/png;base64,iVBORw0KGg[...]QmCC);
                transition: background-color .2s ease-out;
                background-clip: padding-box; /* Fix bleeding */
                border-radius: 3px;
                box-shadow: 0 1px 0 rgba(0, 0, 0, .3),
                0 2px 2px -1px rgba(0, 0, 0, .5),
                0 1px 0 rgba(255, 255, 255, .3) inset;
                text-shadow: 0 1px 0 rgba(255,255,255, .9);
            }

            .button:hover{
                background-color: #eee;
                color: #555;
            }

            .button:active{
                background: #e9e9e9;
                position: relative;
                top: 1px;
                text-shadow: none;
                box-shadow: 0 1px 1px rgba(0, 0, 0, .3) inset;
            }
        </style>
        <?php
        get_header_extra();
        ?>
    </head>
    <body>
        <div id="temp-div" class="noselect">
            <div id="temp-inner-div">
                <?php
                if (isset($message)) {
                    echo $message[1];
                }
                ?>
            </div>
            <img id="hide-temp-div" src="image/close-icon.png" />
        </div>
        <div id="header-div">
            <div id="cms-logo-div">
                <img id="cms-logo" src="image/cms-logo.png" />
            </div><!--
            --><div id="header-rest-div">
                <?php if (is_logged_in()) { ?>
                <span id="btn-op-logout" class="noselect button">
                    Operator Logout
                </span>
                <?php } else { ?>
                <span id="btn-op-login" class="noselect button">
                    Operator Login
                </span>
                <?php } ?>
            </div>
        </div>
        <div id="menubar-div">
            <span id="btn-home" class="menubar-button noselect">Home</span>
            <span id="btn-about-us" class="menubar-button noselect">About Us</span>
            <span id="btn-weather" class="menubar-button noselect">Weather News</span>
            <span id="btn-traffic" class="menubar-button noselect">Traffic Condition</span>
            <span id="btn-report-inc" class="menubar-button noselect">Incident Reporting</span>
            <span id="btn-hotline" class="menubar-button noselect">Hotline</span>
            <?php if (is_logged_in()) { ?>
            <span id="btn-create-inc" class="menubar-button noselect">Create Incident</span>
            <span id="btn-approve-inc" class="menubar-button noselect">Approve Incident</span>
            <span id="btn-deactive-inc" class="menubar-button noselect">Deactivate Incident</span>
            <?php } ?>
        </div>

        <?php
        get_body_extra();
        ?>

        <script src="scripts/jquery/jquery-3.1.1.min.js"></script>
        <script type="text/javascript">
            <?php if (isset($message)) { ?>
            var temp_div = $("#temp-div");
            temp_div.css("display", "block");
            var autohide = setTimeout(function(){
                temp_div.slideUp();
            }, 3000);
            $("#hide-temp-div").on("click", function(){
                if (temp_div.is(":visible")) {
                    clearTimeout(autohide);
                    temp_div.slideUp();
                }
            });
            $("#temp-inner-div").on("click", function(){
                clearTimeout(autohide);
            });
            <?php } ?>
            $("#cms-logo").on("click", function() {
                window.location.href = "index.php?route=home";
            });
            <?php if (is_logged_in()) { ?>
            $("#btn-op-logout").on("click", function() {
                $('body').append(
                    $('<form />', { id: 'logout-form', action: 'index.php?route=op_logout', method: 'POST' }).append(
                        $('<input />', { name: 'user_logout', type: 'hidden' })
                    )
                );
                $('#logout-form').submit();
            });
            <?php } else { ?>
            $("#btn-op-login").on("click", function() {
                window.location.href = "index.php?route=op_login";
            });
            <?php } ?>
            $("#btn-home").on("click", function() {
                window.location.href = "index.php?route=home";
            });
            $("#btn-about-us").on("click", function() {
                window.location.href = "index.php?route=about_us";
            });
            $("#btn-weather").on("click", function() {
                window.location.href = "index.php?route=view_weather";
            });
            $("#btn-traffic").on("click", function() {
                window.location.href = "index.php?route=view_traffic";
            });
            $("#btn-report-inc").on("click", function() {
                window.location.href = "index.php?route=report_incident";
            });
            $("#btn-hotline").on("click", function() {
                window.location.href = "index.php?route=hotline";
            });
            <?php if (is_logged_in()) { ?>
            $("#btn-create-inc").on("click", function() {
                window.location.href = "index.php?route=create_incident";
            });
            $("#btn-approve-inc").on("click", function() {
                window.location.href = "index.php?route=approve_incident";
            });
            $("#btn-deactive-inc").on("click", function() {
                window.location.href = "index.php?route=deactivate_incident";
            });
            <?php } ?>
        </script>

        <?php
        get_body_js();
        ?>
    </body>
</html>