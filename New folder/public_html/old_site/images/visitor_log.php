<table>
	<tr>
		<td>

			<table>
				<tr>
					<td>Site visited</td>
					<td>IP Address</td>
					<td>Country</td>
					<td>Time</td>
				</tr>

<?php

//connect to the database
	include ("dbconnect.php");

// get the provider details
	$query="select * from visitor_log order by timestamp desc limit 0,30;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

        $access_date=date('H:i:s d-m-Y',$row["timestamp"]);

		echo ("<tr><td>".$row["site"]."</td><td>".$row["ip_address"]."</td><td>".$row["country"]."</td><td>".$access_date."</td></tr>");
	}

?>

			</table>

		</td>
		<td valign="top">

			<table>

<?php

	$query = "SELECT distinct(country),count(country) as country_count from visitor_log group by country order by country_count desc;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

		$graph_width=$row["country_count"]*5;

		echo ("<tr><td>".$row["country"]."</td><td><img src=\"images/green.gif\" width=\"".$graph_width."\" height=\"10\"> ".$row["country_count"]."</td></tr>");
	}

?>

			</table>
		</td>
	</tr>
</table>