<head>
	<style>
		* {
		    font-family: helvetica;
		    font-size: 12px;
		}
	</style>
</head>

<body>

	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top"><b>Last 25 visitors</b><p>

				<table>
					<tr>
						<td><b>Site visited</b></td>
						<td><b>IP</b></td>
						<td align="right"><b>Country of origin</b></td>
						<td align="right" width="80"><b>Time</b></td>
					</tr>

<?php

//connect to the database
	include ("dbconnect.php");

// get the provider details
	$query="select * from visitor_log order by timestamp desc limit 0,25;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

// convert UNIX timestamp to human readable format
        $access_date=date('H:i:s',$row["timestamp"]);

// write out the data
		echo ("<tr><td><font color=\"#bcbcbc\">www.</font><font color=\"#000000\">".$row["site"]."</font><font color=\"#bcbcbc\">.com</font></td>");
		echo ("<td><img src=\"images/globe.png\" title=\"".$row["ip_address"]."\"></td>");
		echo ("<td align=\"right\">".$row["country"]."</td>");
		echo ("<td align=\"right\">".$access_date."</td></tr>");
	}

?>

				</table>

			</td>
			<td width="25"><img src="images/trans.gif" width="50" height="1"></td>
			<td bgcolor="#2c2c2c"><img src="images/trans.gif" width="1" height="1"></td>
			<td width="25"><img src="images/trans.gif" width="50" height="1"></td>
			<td valign="top">

				<table>
					<tr>
						<td><b>Visitor Graph (top 25)</b><p>

							<table>
								<tr>
									<td><b>Country</b></td>
									<td><b>Number of Visitors</b></td>
								</tr>

<?php

// get the top 10 countries and their visiting count
	$query = "SELECT distinct(country),count(country) as country_count from visitor_log group by country order by country_count desc limit 25;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

// If the country is XX then rename it as unknown
		if ($row["country"]=='XX'){
			$row["country"]='Unknown (XX)';
		}

		$row["country"]=substr($row["country"], 0, -5);
		
		$country_count=$row["country_count"]/10;
		
		if ($country_count<1){
			$country_count=1;
		}

		echo ("<tr><td valign=\"top\">".$row["country"]."</td><td valign=\"top\"><img src=\"images/green.gif\" width=\"".$country_count."\" height=\"10\"> ".$row["country_count"]."</td></tr>");
	}

?>

							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>