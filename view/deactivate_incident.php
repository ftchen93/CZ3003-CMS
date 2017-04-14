<?php

require_log_in();

function head_extra()
{
    ?>
    <title>Deactivate Incident Form</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #deactivate-inc-div {
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
        }
    </style>
    <?php
}

function body_extra()
{
    global $approved_inc;
    ?>
    <div id="main-cont-div">
        <div>
            <h1>Deactivate Incident Form</h1>
        </div>
        <br/>
        <div id="deactivate-inc-div">
            <form id="deactivate-inc-form" action="index.php?route=deactivate_incident" method="POST">
                <?php if (isset($approved_inc) && count($approved_inc) > 0) { ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Incident Type</th>
                        <th>Reported Time</th>
                        <th>Lat : </th>
                        <th>Lng : </th>
                        <th>Message</th>
                        <th>Deactivate?</th>
                    </tr>
                    <?php
                    foreach ($approved_inc as $incident) {
                        $row_data = '
                        <tr>
                            <td>'.$incident["id"].'</td>
                            <td>'.$incident["type"].'</td>
                            <td>'.$incident["time"].'</td>
                            <td>'.$incident["lat"].'</td>
                            <td>'.$incident["lng"].'</td>
                            <td>'.$incident["msg"].'</td>
                            <td><input type="checkbox" name="'.$incident["id"].'[]" value="Deactivate"></td>
                        </tr>
                        ';
                        echo $row_data;
                    };
                    ?>

                    <tr>
                        <td colspan = 6></td>
                        <td>
                            <input type="button" id="btn-submit" value="Deactivate" />
                        </td>
                    </tr>
                </table>
                <?php } else { ?>
                    <span>No approved incidents available for deactivation!</span>
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
            $("#deactivate-inc-form").submit();
        });
    </script>
    <?php
}
?>