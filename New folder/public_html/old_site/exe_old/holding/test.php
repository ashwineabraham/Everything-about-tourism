<?php

	include ("dbconnect.php");

// create our variables
	$site='';
	$country_code='';
	$country_name='';
	$region='';
	$category='';

// set the SITE variable either from the cookie value or a passer parameter
	if (isset($_COOKIE["site"])){
		$site=$_COOKIE["site"];
	}else{
		setcookie("site",$_GET["site"]);
		$site=$_GET["site"];
	}

// if the COUNTRY variable has been passed then
	if (isset($_GET["cboCountryCode"])){

// set a cookie with that value
		setcookie("cboCountryCode",$_GET["cboCountryCode"]);

// set the COUNTRY_CODE variable to the passed variable - this will be a two character code such as AU
		$country_code=$_GET["cboCountryCode"];
		
// get the full country name for the passed country code and set it as a variablw
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
	echo ("\n<script type=\"text/javascript\">\n");
	echo ("parent.LIST.location.href='list.php';");
	echo ("</script>\n");

?>

<body topmargin="5" leftmargin="5">

	<form name="test" action="test.php" method="GET">

	<table width="100%" border="0">
		<tr>
			<td align="right"><img src="images/button_end_left.gif"><img src="images/choose_country.gif"><img src="images/button_end_right.gif"></td>
			<td align="right"><img src="images/button_end_left.gif"><img src="images/choose_state.gif"><img src="images/button_end_right.gif"></td>
			<td align="right"><img src="images/button_end_left.gif"><img src="images/choose_category.gif"><img src="images/button_end_right.gif"></td>
			<td width="100%" align="right"><img src="images/button_end_left.gif"><img src="images/add_your_website.gif"><img src="images/button_end_right.gif"></td>
		</tr>
		<tr>
			<td align="right">

<?php

// create our first drop down box
	echo ("<select NAME=\"cboCountryCode\" size=\"1\" onchange=\"this.form.submit()\">");
	echo ("<option value=\"\" selected>Choose a country</option>");
	echo ("<option value=\"all\">== All ==</option>");

// get all active country codes and names
	$query="select country_name, country_code from countries where country_enabled='TRUE' order by country_name asc;";
	$result=mysql_query($query);

// create a row for each
	while ($row = mysql_fetch_array($result)) {
    	echo ("<option value=\"".$row["country_code"]."\"");

    	if ($country_name==$row["country_name"]){
    		echo (" selected");
    	}

    	echo (">".$row["country_name"]."</option>\n");
    }

// finish the selection
    echo ("</select>");

?>

		</td>
		<td valign="top" align="right">

<?php

	if (isset($country_name)){
			
		echo ("<select NAME=\"cboStateCode\" size=\"1\" onchange=\"this.form.submit()\">");
		echo ("<option value=\"\" selected>Choose a state</option>");
		echo ("<option value=\"all\"");

		if ($region=='all'){
			echo (" selected");
		}

		echo (">== All ==</option>");

		$query="select distinct(providerstatecode) as providerstatecode from provider where providercountrycode='".$country_code."' and providerstatecode != '' order by providerstatecode asc;";
		$result=mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			echo ("<option value=\"".$row["providerstatecode"]."\"");
			
			if ($region==$row["providerstatecode"]){
				echo (" selected");
			}
		
			echo (">".$row["providerstatecode"]."</option>\n");
		}
		echo ("</select>");

	} else {
		echo ("<font face=\"arial\" size=\"-1\">Choose a country</font>");
	}

?>

		</td>
		<td valign="top" align="right">

<?php

// create the category drop-down
	echo ("<select NAME=\"category\" size=\"1\" onchange=\"this.form.submit()\">");
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
		<td></td>
	</tr>
	</form>
</table>
</body>
