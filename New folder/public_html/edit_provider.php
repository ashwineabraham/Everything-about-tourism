<?php

//connect to the database
	include ("dbconnect.php");

// get the provider details
	$query="select * from provider where providerid='".$_GET["ptovider_id"]."';";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

