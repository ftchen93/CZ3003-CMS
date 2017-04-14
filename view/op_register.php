<?php

function head_extra()
{
    ?>
    <title>Register</title>
    <style type="text/css">
        #login-table {
            border: 1px solid black;
        }
    </style>
    <?php
}

function body_extra() {
    ?>
    <form id="login-form" action="index.php?route=op_register" method="post">
        <div>
            <h2>Account Registration</h2>
            <table id="login-table">
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" id="user-name" name="user_name"/>
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" id="user-pwd" name="user_pwd"/>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" id="user-cfmpwd" name="user_cfmpwd"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" id="btn-submit" value="Register"/>
                        <input type="button" id="btn-back" value="Back to Login"/>
                    </td>
                </tr>
            </table>
        </div>
    </form>
    <?php
}

function body_js() {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#user-name").focus();
        });
        function check_submit() {
            var username, userpwd, usercfmpwd;
            username = $('#user-name').val();
            userpwd = $('#user-pwd').val();
            usercfmpwd = $('#user-cfmpwd').val();
            if (username == "" || userpwd == "" || usercfmpwd == "") {
                alert("Please fill in all fields!");
            }
            else if (userpwd.length < 6) {
                alert("Password must have at least 6 characters!");
                $('#user-pwd').focus();
            }
            else if (userpwd != usercfmpwd) {
                alert("Entered passwords do not match!");
                $('#user-pwd').focus();
            }
            else
                $('#login-form').submit();
        }
        $("#user-name, #user-pwd, #user-cfmpwd").keypress(function (e) {
            if (e.which == 13) {
                check_submit();
                return false;    //<---- Add this line
            }
        });
        $('#btn-submit').on('click', function() {
            check_submit();
        });
        $('#btn-back').on('click', function() {
            window.location.href = "index.php?route=login";
        });
    </script>
    <?php
}

?>