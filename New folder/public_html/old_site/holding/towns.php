<?php

	include ("dbconnect.php");

	$query="select name from locations where region='".$_GET["region"]."' and name like '".$_GET["letter"]."%' order by name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	echo $row["name"]."<br>";
    }

?>