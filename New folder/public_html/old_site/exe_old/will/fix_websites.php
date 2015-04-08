<?php

	include ("dbconnect.php");

	$query="select * from website where WebSite not like 'http://%';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

    	echo $row["WebSite"]."<br>";

    }

?>
