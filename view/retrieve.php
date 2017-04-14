<?php

if (apcu_exists("test")) {
    var_dump(apcu_fetch("test"));
}
echo "</br></br></br>";
if (apcu_exists("traf_inc")) {
    var_dump(apcu_fetch("traf_inc"));
}

?>