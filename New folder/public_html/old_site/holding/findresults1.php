<font face="arial" size="-1">

<?php

	include ("dbconnect.php");

// check for matching keywords

	$query="select count(*) as counted from attractions where attraction_keywords like '%".$_POST["searchq"]."%';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	$matched=$row["counted"];
    }

	if (($matched>0)and($matched<5)){
		echo ("<b>Keywords</b><p>");
		echo ("<table>");
		$query="select attraction_keywords from attractions where attraction_keywords like '%".$_POST["searchq"]."%';";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	echo "<tr><td valign=\"top\"><img src=\"balloon-box-left.png\" border=\"0\"></td><td><font face=\"arial\" size=\"-1\">".$row["attraction_keywords"]."</font></td></tr>";
	    }
	    echo ("</table>");
	}

	if ($matched>5){
	    echo "<b>Too many keywords (".$matched.")</b>";
	}

	if ($matched<1){
	    echo "<b>No matching keywords</b>";
	}

	echo ("<hr>");

// check for matching attractions by name or keyword

	$query="select count(*) as counted from attractions where attraction_name like '%".$_POST["searchq"]."%' or attraction_keywords like '%".$_POST["searchq"]."%';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	$matched=$row["counted"];
    }

	if (($matched>0)and($matched<21)){
		echo ("<b>Attractions</b><p>");
		echo ("<table>");
		$query="select attraction_name, attraction_locationid, attraction_id from attractions where attraction_name like '%".$_POST["searchq"]."%' or attraction_keywords like '%".$_POST["searchq"]."%';";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	echo "<tr><td valign=\"top\"><a href=\"list.php?attraction_id=".$row["attraction_id"]."\" target=\"LIST\"><img src=\"image.png\" border=\"0\"></a></td><td><font face=\"arial\" size=\"-1\">".$row["attraction_name"]."</font></td></tr>";
	    }
	    echo ("</table>");
	}

	if ($matched>20){
	    echo "<b>Too many attractions (".$matched.")</b>";
	}

	if ($matched<1){
	    echo "<b>No matching attractions</b>";
	}

	echo ("<hr>");

// check for locations that match the search criteria

	$query="select count(*) as counted from locations;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	$total=$row["counted"];
    }

	$query="select count(*) as counted from locations where name like '%".$_POST["searchq"]."%';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	$matched=$row["counted"];
    }

// if there are more than zero and less than 20 matches
	if (($matched>0)and($matched<21)){
		echo ("<b>Locations</b><p>");
		echo ("<table>");
		$query="select name, location_id from locations where name like '%".$_POST["searchq"]."%';";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	echo "<tr><td valign=\"top\"><a href=\"location.php?location_id=".$row["location_id"]."\ target=\"LIST\"><img src=\"map.png\" border=\"0\"></a></td><td><font face=\"arial\" size=\"-1\">".$row["name"]."</font></td></tr>";
	    }

	}

// if there are more than 20 matches

	if ($matched>20){
	    echo "<b>Too many locations (".$matched.")</b>";
	}

// if there are no matches
	
	if ($matched<1){
	    echo "<b>No locations</b>";
	}

?>

</font>