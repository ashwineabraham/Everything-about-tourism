<?php
    mysql_connect("127.0.0.1", "worldfin_root", "Zombie6Fire") or die(mysql_error());
    mysql_select_db("worldfin_finance") or die(mysql_error());
    date_default_timezone_set ("Australia/Hobart");
?>
