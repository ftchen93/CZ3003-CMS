<?php

function head_extra()
{
    ?>
    <title>Hotline</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
    </style>
    <?php
}

function body_extra()
{
    ?>
    <div id="main-cont-div">
        <div>
            <h1>Hotline</h1>
			<br/>
			<div id="hotline-inc-div">
				Please contact our hotline at <a href="">+65 9123 4567</a> to report an incident.
				<br/><br/>
				Alternatively, you can report an incident using our <a href="index.php?route=report_incident">Incident Reporting Form</a>
			</div>
        </div>
        <br/>
    </div>
    <?php
}

function body_js()
{
    ?>

    <?php
}
?>