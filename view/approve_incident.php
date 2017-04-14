<?php

require_log_in();

function head_extra()
{
    ?>
    <title>Approve Incident Form</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #approve-inc-div {
            display: inline-block;
        }
        table {
            border:1px solid #000;
        }
        tr {
            border:1px solid #000;
        }
        th {
            border:1px solid #000;
        }
        td {
            border:1px solid #000;
            text-align: left;
        }
        td:last-child {
            text-align: center;
        }
    </style>
    <?php
}

function body_extra()
{
    global $pending_inc;
    ?>
    <div id="main-cont-div">
        <div>
            <h1>Approve Incident Form</h1>
        </div>
        <br/>
        <div id="approve-inc-div">
            <form id="approve-inc-form" action="index.php?route=approve_incident" method="POST">
                <?php if (isset($pending_inc) && count($pending_inc) > 0) { ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Incident Type</th>
                        <th>Reported Time</th>
                        <th>Latitude</th>
                        <th>Longtitude</th>
                        <th>Message</th>
                        <th>Agencies to report</th>
                        <th>Approve?</th>
                    </tr>
                    <?php
                    foreach ($pending_inc as $incident) {
                        $row_data = '
                        <tr>
                            <td>'.$incident["id"].'</td>
                            <td>'.$incident["type"].'</td>
                            <td>'.$incident["time"].'</td>
                            <td>'.$incident["lat"].'</td>
                            <td>'.$incident["lng"].'</td>
                            <td>'.$incident["msg"].'</td>
                            <td><label></labeel><input type="checkbox" name="'.$incident["id"].'[]" value="Ambulance"> Emergency Ambulance</label><br>
                                <label><input type="checkbox" name="'.$incident["id"].'[]" value="Evacuation"> Rescue and Evacuation<label><br>
                                <label><input type="checkbox" name="'.$incident["id"].'[]" value="FireFighting"> Fire-Fighting<label></td>
                            <td><input type="checkbox" name="'.$incident["id"].'[]" value="Approve"></td>
                        </tr>
                        ';
                        echo $row_data;
                    }
                    ?>
                    <tr>
                        <td colspan = 7></td>
                        <td>
                            <input type="button" id="btn-submit" value="Approve" />
                        </td>
                    </tr>
                </table>
                <?php } else { ?>
                <span>No pending incidents available for approval!</span>
                <?php } ?>
            </form>
        </div>
    </div>
    <?php
}

function body_js()
{
    ?>
    <script type="text/javascript">
        $("#btn-submit").on("click", function () {
            $("#approve-inc-form").submit();
            console.log("A");
        });
    </script>
    <?php
}
?>