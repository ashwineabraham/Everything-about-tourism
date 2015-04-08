<head>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0
        }

        * {
            font-family: helvetica;
        }
    </style>
</head>

<?php

	include ("dbconnect.php");

// get the URL requested by the client
    $actual_link = $_SERVER[HTTP_HOST];

// deconstruct the URL using the "." as a delimter
    $link_array=explode('.',$actual_link);

// if the first array value is "www"..
    if ($link_array[0]==='www'){

// then use the second array value to test with
        $site_name=$link_array[1];
    }else{

// otherwise the www is missing and the first array value holds the site name
        $site_name=$link_array[0];
    }

// grab the site details from the SITE_DETAILS table based on the URL
    $query="select * from site_details where site_name='".$site_name."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        
// set a bunch of variables we'll use to define the colour, title, and base SITEKEY
        $site_key=$row["site_key"];
        $site_colour=$row["site_colour"];
        $site_title=$row["site_title"];

    }

	switch ($site_key){
		case "finance":
			$colour="#822a25";
			break;
		case "tourism":
			$colour="#005186";
			break;
		default:
			$colour="#005186";
			break;
	}

// get the user ID associated with this hash - dont want to pass as a cookie value in case it might be spoofed
	$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// store the user ID for later
		$user_id=$row["user_id"];
	}

?>
	
<body>

	<table width="100%" height="100%" cellspacing="0">
  		<tr>
  			<td valign="top" width="35%">
  				<font face="arial" size="-1"><b>Instructions</b><p>To add a new provider you will need to enter in the details asked for on the right of this screen.<p>You can choose up to five seperate categories however there is no requirement to choose more than one.<p><b>Note that the added provider will not be listed until approved.</b></font>
  			</td>
  			<td><img src="images/trans.gif" width="20" height="1"></td>
			<td valign="top">

<?php

    if (isset($_GET["submitted"])){
        echo ("<table>");
        echo ("<tr><td>");
        include ("red_start.inc");
        echo ("<font face=arial size=-1 color=#ffffff><center>Provider Submitted</center></font>");
        include ("red_end.inc");
        echo ("</td></tr></table>");
    }

?>

				<table>
					<tr>
						<td valign="top">

							<form name="register_now" action="add_listing.php" method="POST">
								<input type="hidden" name="contractor_id" value="<?php echo $user_id; ?>">
								<table>
									<tr>
										<td><font face="arial" size="-1"><b>Business Name</font></td>
										<td><input type="text" size="45" name="business_name"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Address</font></td>
										<td><input type="text" size="45" name="address"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>City or Town</font></td>
										<td><input type="text" size="45" name="city"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Country</font></td>
										<td><input type="text" size="45" name="country"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>State/Region/Province</font></td>
										<td><input type="text" size="45" name="state"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Zipcode/Postcode</font></td>
										<td><input type="text" size="45" name="postcode"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Contact Person's Name</font></td>
										<td><input type="text" size="45" name="contact"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Phone</font></td>
										<td><input type="text" size="45" name="phone"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Mobile/Cellular</font></td>
										<td><input type="text" size="45" name="mobile"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Fax</font></td>
										<td><input type="text" size="45" name="fax"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>E-Mail</font></td>
										<td><input type="text" size="45" name="email"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Association No. if applicable</font></td>
										<td><input type="text" size="45" name="assoc_no"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Website</font></td>
										<td><input type="text" size="45" name="website"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Website Description</font></td>
										<td><input type="text" size="45" name="website_desc"></td>
									</tr>
									<tr>
										<td><font face="arial" size="-1"><b>Category</font></td>							

<?php

	include ("dbconnect.php");

	$site=$_COOKIE["site"];

	for ($counter=1;$counter<6;$counter++){

		if ($counter>1){
			echo ("<td></td><td>");
		} else {
			echo ("<td>");
		}

		echo ("<select NAME=\"category".$counter."\" size=\"1\" width=\"45\">");
		echo ("<option value=\"\"");

		echo (">Choose a Category</option>");

		$site=strtoupper($site);

		// using the SITEKEY variable grab a list of all matching categories sorted alphabetically
		$query="select categdesc, categid from vCategory where sitekey like '".$site."' and categdesc <> '' order by categdesc asc;";
		$result=mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			echo ("<option value=\"".$row["categid"]."\"");

			if ($category==$row["categid"]){
				echo (" selected");
			}

			echo (">".$row["categdesc"]."</option>\n");
		}
		
		echo ("</select></td>");

		echo ("</tr><tr>");
	}

?>

										<td colspan="2" align="right"><input type="submit" value="Add your new provider"></td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</td>

<!-- right column -->

		</tr>
	</table>

</body>