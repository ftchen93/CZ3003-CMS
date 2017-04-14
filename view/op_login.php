<?php

function head_extra()
{
    ?>
    <title>Login</title>
    <style type="text/css">
        #main-cont-div {
            margin: 40px;
            text-align: center;
        }
        #login-div {
            display: inline-block;
            text-align: left;
        }
        #login-table {
        }
        #login-table .row-separator {
            height: 13px;
            width: 0;
        }
        #login-table .col-separator {
            height: 0;
            width: 8px;
        }
        #buttons-td {
            text-align: center;
        }
    </style>
    <?php
}

function body_extra() {
    ?>
    <div id="main-cont-div">
        <div>
            <h1>Operator Login</h1>
        </div>
        <br/>
        <form id="login-form" action="index.php?route=op_login" method="post">
            <div id="login-div">
                <table id="login-table">
                    <tr>
                        <td>Username:</td>
                        <td class="col-separator"></td>
                        <td>
                            <input type="text" id="user-name" name="user_name"/>
                        </td>
                    </tr>
                    <tr class="row-separator"></tr>
                    <tr>
                        <td>Password:</td>
                        <td class="col-separator"></td>
                        <td>
                            <input type="password" id="user-pwd" name="user_pwd"/>
                        </td>
                    </tr>
                    <tr class="row-separator"></tr>
                    <tr>
                        <td id="buttons-td" colspan="3">
                            <input type="button" id="btn-submit" value="Login"/>
                            <!--<input type="button" id="btn-register" value="Register Account"/>-->
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <?php
}

function body_js() {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#user-name").focus();
        });
        function check_submit() {
            if ($('#user-name').val() != "" && $('#user-pwd').val() != "") {
                $('#login-form').submit();
            }
            else
                alert("Please fill in all fields!");
        }
        $("#user-name, #user-pwd").keypress(function (e) {
            if (e.which == 13) {
                check_submit();
                return false;    //<---- Add this line
            }
        });
        $('#btn-submit').on('click', function() {
            check_submit();
        });
        $('#btn-register').on('click', function() {
            window.location.href = "index.php?route=register";
        });
    </script>
    <?php
}

?>