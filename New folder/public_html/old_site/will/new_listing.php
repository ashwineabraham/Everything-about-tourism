<head>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0
        }

        body{
            margin: 0;
            padding: 0
        }

        @font-face {
            font-family: 'titilliumregular';
            src: url('titillium-regular.eot');
            src: url('titillium-regular.eot?#iefix') format('embedded-opentype'),
                 url('titillium-regular.woff') format('woff'),
                 url('titillium-regular.ttf') format('truetype'),
                 url('titillium-regular.svg#titilliumregular') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        @font-face {
            font-family: 'titillium_bdbold';
            src: url('titillium-bold.eot');
            src: url('titillium-bold.eot?#iefix') format('embedded-opentype'),
                 url('titillium-bold.woff') format('woff'),
                 url('titillium-bold.ttf') format('truetype'),
                 url('titillium-bold.svg#titillium_bdbold') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        h1{
            font-family: titilliumregular;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
            text-shadow: 3px 3px 2px rgba(150, 150, 150, 0.7);
            font-size: 52px;
        }

        body{
            margin: 0;
            padding: 0
        }
		select {
			width:267px;
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

?>
	
<body>

	<table width="100%" height="100%" cellspacing="0">
        <tr>
            
                <td colspan="3" height="164" background="images/<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
                
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                    <tr>
                        <td valign="middle"><h1><?php echo $site_title; ?></h1></td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                </table></center>

            </td>
        </tr>
  		<tr>

<!-- left column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200" height="1"></td>

<!-- content column -->

			<td valign="top">
				<table>
					<tr>
						<td valign="top">

							<font face="arial" size="+2"><center><b>LIST YOUR BUSINESS AND MAKE PAYMENT</center></font><p>

							<font face="arial" size="-1">This is your point of entry to list Your Business and Web Site on the World Finance Search Engines' Top 20 Global Finance and Financial Services Search Directories.<p>

							When you have selected your option and completed payment and all other details, your Business will be automatically linked to All Top 20 Global Finance and Financial Services Search Directories.<p>

							<table border="0">
								<tr>
									<td colspan="3"><font face="arial" size="+1"><b>Annual Listing Fee Schedule:</font></td>
									<td><img src="images/trans.gif" width="10" height="1"></td>
									<td rowspan="2">

										<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
											<input type="hidden" name="cmd" value="_s-xclick">
											<input type="hidden" name="hosted_button_id" value="JUFJ5R5RD5JH4">
											<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
											<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
										</form>

									</td>
								</tr>
								<tr>
									<td valign="top"><font face="arial" size="-1">Listing on all Top 20 Sites:<br>
									<td><img src="images/trans.gif" width="10" height="1"></td>
									<td valign="top"><font face="arial" size="-1">US$39 Annual Registration Fee Ongoing</font></td>
									<td><img src="images/trans.gif" width="10" height="1"></td>
								</tr>
							</table><p>

							(Check your currency here: <a href="http://www.xe.com" target="_new">http://www.xe.com</a>) - if, at anytime you wish to cancel your ongoing annual listing, please advise us by email to <a href="mailto:cancel@worldfinancesearchengines.com">cancel@worldfinancesearchengines.com</a> and we will immediately cancel any annual payments and worldwide listings for you.<p>

							<font face="arial" size="+1"><b>Our Special Introductory Offer Is...</font><p>

							For a Limited Time Only, Your Listing includes registrations on The World's Top 20 Specialized Finance Search Engines, plus up to 5 Categories if these are directly applicable to Your Business, completely free of charge, ongoing year after year if you wish to continue...<p>

							...A Huge Saving for You Listing on All Top 20 Finance Sites Free of Charge via Payment to Any One of The Top 20 Global Finance and Financial Services Search Directories at Only US39pa!<p>

							<font face="arial" size="+1"><b>HOW TO PAY</font><p>
							After you have entered your data, the system will ask you what Categories You would like to publish on Your Worldwide Listing as mentioned above, and then you can continue with the secure Paypal online payment.
							
							<form name="register_now" action="add_listing.php" method="POST">
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

										<td colspan="2" align="right"><input type="submit" value="Sign up Now!"></td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</td>

<!-- right column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200"></td>
		</tr>
	</table>

</body>