<?php

// set the expiration date to one hour ago

	$finance_sitename_array=array('thefinancetoolkit','10outof10financiers','1stclassfinanciers','5starfinanciers','all-about-finance','a-zoffinance','bestfinancebusinesses','everything-about-finance','everythingforfinance','financebestbuys','financeencyclopedias','financealist','financewhoswho','thefinancehelpdesk','thefinancesearchengine','thefinancespecialist','top100infinance','worldsfinancedirectory','worldsfinanciers');
	$disability_sitename_array=array('a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine');
	$tourism_sitename_array=array('allabouttourism','atozoftourism','besttourismbusinesses','everythingabouttourism','top100intourism','tourismalist','tourismbestbuys','tourismsearchengine','whoswhointourism','worldstourismdirectory');

	$blue_buttons_array=array('10outof10financiers','everything-about-finance','financealist','financebestbuys','financewhoswho','thefinancesearchengine','top100infinance','worldsfinancedirectory','worldtourismsearchengines','a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine');
	$yellow_buttons_array=array('1stclassfinanciers');
	$black_buttons_array=array('everythingforfinance','5starfinanciers','bestfinancebusinesses','everythingforfinance','thefinancespecialist','worldsfinanciers','thefinancehelpdesk');
	$white_buttons_array=array('all-about-finance');
	$red_buttons_array=array('financeencyclopedias','a-zoffinance');

	unset($_COOKIE['site']);
 	setcookie('site', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["cboCountryCode"]);
 	setcookie('cboCountryCode', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["cboCountryName"]);
 	setcookie('cboCountryName', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["cboStateCode"]);
 	setcookie('cboStateCode', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["category"]);
 	setcookie('category', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["region"]);
 	setcookie('region', '', time() - 3600); // empty value and old timestamp

// connect to the database
	include ("dbconnect.php");

// get the URL requested by the client
	$actual_link = $_SERVER[HTTP_HOST];

// deconstruct the URL using the "." as a delimter
	$link_array=explode('.',$actual_link);

// if the first array value is "www"..
	if ($link_array[0]==='www'){

// then use the second array value to test with
		$site_image=$link_array[1];
	}else{

// otherwise the www is issing and the first array value holds the site name
		$site_image=$link_array[0];
	}

// destroy these variables
	unset($link_array);
	unset($actual_link);

// create our variables
	$site='';
	$country_code='';
	$country_name='';
	$region='';
	$category='';

// set the SITE variable either from the cookie value or a passer parameter
// note the SITEKEY needs to be FINANCE for the finance sites to work as this is the value stored in the vCategory table.. ah legacy crap..
	if (isset($_COOKIE["site"])){
		$site=$_COOKIE["site"];
	}else{

		if (in_array($site_image,$finance_sitename_array)){
			$site="finance";
			setcookie("site","finance");
		}
		if (in_array($site_image,$disability_sitename_array)){
			$site="disabilty";
			setcookie("site","disabilty");
		}
		if (in_array($site_image,$tourism_sitename_array)){
			$site="tourism";
			setcookie("site","tourism");
		}
	}

	if (in_array($site_image,$blue_buttons_array)){
		$button_colour="blue";
	}
	if (in_array($site_image,$yellow_buttons_array)){
		$button_colour="yellow";
	}
	if (in_array($site_image,$black_buttons_array)){
		$button_colour="black";
	}
	if (in_array($site_image,$white_buttons_array)){
		$button_colour="white";
	}
	if (in_array($site_image,$red_buttons_array)){
		$button_colour="red";
	}

// if the COUNTRY variable has been passed then
	if (isset($_GET["cboCountryCode"])){

// set a cookie with that value
		setcookie("cboCountryCode",$_GET["cboCountryCode"]);

// set the COUNTRY_CODE variable to the passed variable - this will be a two character code such as AU
		$country_code=$_GET["cboCountryCode"];
		
// get the full country name for the passed country code and set it as a variable
		$query="select country_name from countries where country_code='".$country_code."';";
		$result=mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			setcookie("cboCountryName",$row["country_name"]);
			$country_name=$row["country_name"];
		}
	}

// if the state variable has been passed set the cookie and a variable to suit
	if (isset($_GET["cboStateCode"])){
		setcookie("cboStateCode",$_GET["cboStateCode"]);
		$region=$_GET["cboStateCode"];
	}

// if the category variable has been passed set the cookie and a variable to suit
	if (isset($_GET["category"])){
		setcookie("category",$_GET["category"]);
		$category=$_GET["category"];
	}

// refresh the LIST frame which uses the cookie values set above to define its search parameters
//	echo ("\n<script type=\"text/javascript\">\n");
//	echo ("parent.LIST.location.href='list.php';");
//	echo ("</script>\n");
?>

<html>
<body>

<center>

	<form name="welcome" method="POST" action="list.php">

	<table cellpadding="10" cellspacing="10" border="0">
		<tr>
			<td rowspan="6"><img src="images/<?php echo $site_image; ?>_logo.jpg"></td>
			<td valign="top">
				<table>
					<tr>
						<td colspan="2"><img src="images/<?php echo $site_image; ?>_title.jpg"></td>
					</tr>
					<tr>
						<td colspan="2"><img src="images/trans.gif" width="1" height="20"></td>
					</tr>
					<tr>
						<td><img src="images/<?php echo $button_colour; ?>_choose_country.png"></td>
						<td>

<?php

// create our first drop down box
	echo ("<select NAME=\"cboCountryCode\" size=\"1\">");
	echo ("<option value=\"\" selected>Choose a country</option>");
	echo ("<option value=\"all\">== All ==</option>");

// get all active country codes and names
	$query="select country_name, country_code from countries where country_enabled='TRUE' order by country_name asc;";
	$result=mysql_query($query);

// create a row for each
	while ($row = mysql_fetch_array($result)) {
    	echo ("<option value=\"".$row["country_code"]."\"");

    	if ($country_code===$row["country_code"]){
    		echo (" selected");
    	}

    	echo (">".$row["country_name"]."</option>\n");
    }

// finish the selection
    echo ("</select>");

?>

						</td>
					</tr>
					<tr>
						<td><img src="images/<?php echo $button_colour; ?>_choose_category.png"></td>
						<td>

<?php

// create the category drop-down
	echo ("<select NAME=\"category\" size=\"1\">");
	echo ("<option value=\"\"");

	echo (">Choose a category</option>");
	echo ("<option value=\"all\"");

	if ($category=='all'){
		echo (" selected");
	}

	echo (">== All ==</option>");

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
						<td><input type="submit" id="search-submit" value="" style="background-image: url(images/<?php echo $button_colour; ?>_search.png); border: solid 0px #000000; width: 139px; height: 28px;"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><img src="images/trans.gif" width="1" height="20"></td>
					</tr>
					<tr>
						<td><img src="images/<?php echo $button_colour; ?>_add_your_website.png"></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</form>

</center>
</body>
</html>






