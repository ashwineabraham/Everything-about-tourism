<font face="arial" size="-1">LIST YOUR BUSINESS AND MAKE PAYMENT<p>

This is your point of entry to list your Business and Web Site on World Finance Search Engines' Top 20 Global Finance and Financial Services Search Directories.<p>

When you have selected your option and completed payment and all other details, your Business will be automatically linked either to the Top 20 web sites, or to only the Everything-about-Finance.com site.<p>

<table>
	<tr>
		<td colspan="3"><font face="arial" size="-1">Annual Fee Schedule:</font></td>
	</tr>
	<tr>
		<td valign="top"><font face="arial" size="-1">Listing on all Top 20 Sites:<br>
		<td valign="top"><font face="arial" size="-1">US$39 Annual Registration Fee</font></td>
	</tr>
</table><p>

(Check your currency here: <a href="http://www.xe.com" target="_new">http://www.xe.com</a>)<p>

OUR SPECIAL INTRODUCTORY OFFER IS<br>
Your listing includes one finance search category plus the option for 4 additional categories (at a charge of US$12 each). However, for a Limited Time Only these 4 additional categories are completely free of charge.. A huge savings if you list on all Top 20 sites!<p>

HOW TO PAY<br>
After you have entered your data, the system will ask you where you would like to publish your listing as mentioned above, and then you can continue with the online payment."

<form name="register_now" action="add_listing.php" method="POST">
	<table>
		<tr>
			<td><font face="arial" size="-1">Business Name</font></td>
			<td><input type="text" name="business_name"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Address</font></td>
			<td><input type="text" name="address"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">City or Town</font></td>
			<td><input type="text" name="city"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Country</font></td>
			<td><input type="text" name="country"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">State</font></td>
			<td><input type="text" name="state"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Postcode</font></td>
			<td><input type="text" name="postcode"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Contact</font></td>
			<td><input type="text" name="contact"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Phone</font></td>
			<td><input type="text" name="phone"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Mobile</font></td>
			<td><input type="text" name="mobile"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Fax</font></td>
			<td><input type="text" name="fax"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">E-Mail</font></td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Association No.</font></td>
			<td><input type="text" name="assoc_no"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Website</font></td>
			<td><input type="text" name="website"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Website Description</font></td>
			<td><input type="text" name="website_desc"></td>
		</tr>
		<tr>
			<td><font face="arial" size="-1">Category</font></td>
			<td>

<?php

	include ("dbconnect.php");

	$site=$_COOKIE["site"];

	$site="FINANCE";

	echo ("<select NAME=\"category1\" size=\"1\">");
	echo ("<option value=\"\"");

	echo (">Choose a category</option>");

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
    echo ("</select>");
?>

			</td>
		</tr>
		<tr>
			<td></td>
			<td>

<?php

	echo ("<select NAME=\"category2\" size=\"1\">");
	echo ("<option value=\"\"");

	echo (">Choose a category</option>");

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
    echo ("</select>");
?>

			</td>
		</tr>
		<tr>
			<td></td>
			<td>

<?php

	echo ("<select NAME=\"category3\" size=\"1\">");
	echo ("<option value=\"\"");

	echo (">Choose a category</option>");

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
    echo ("</select>");
?>

			</td>		</tr>
		<tr>
			<td></td>
			<td>

<?php

	echo ("<select NAME=\"category4\" size=\"1\">");
	echo ("<option value=\"\"");

	echo (">Choose a category</option>");

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
    echo ("</select>");
?>

			</td>		</tr>
		<tr>
			<td></td>
			<td>

<?php

	echo ("<select NAME=\"category5\" size=\"1\">");
	echo ("<option value=\"\"");

	echo (">Choose a category</option>");

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
    echo ("</select>");
?>

			</td>		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit"></td>
		</tr>
	</table>
</form>