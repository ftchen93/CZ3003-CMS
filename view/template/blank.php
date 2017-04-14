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
                /*min-width: 1300px;*/
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
            #main-cont-div {
                text-align: left !important;
                margin: 0 !important;
            }
            h1 {
                display: none;
            }
            br {
                display: none;
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
        </script>

        <?php
        get_body_js();
        ?>
    </body>
</html>