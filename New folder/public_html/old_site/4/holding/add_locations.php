<?php

	include ("dbconnect.php");

	$query="select * from attractions;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

    	$attraction_id=$row["attraction_id"];

    	$array=explode(", ", $row["attraction_keywords"]);

    	$query2="select location_id from locations where name='".$array[0]."' and region='".$array[1]."';";
		$result2=mysql_query($query2);
		while ($row2 = mysql_fetch_array($result2)) {  	
			echo $row2["location_id"]." <- ".$array[0]." ",$array[1]."<br>";
			mysql_query("update attractions set attraction_locationid='".$row2["location_id"]."' where attraction_id='".$attraction_id."';");
		}
	}
?>