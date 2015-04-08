<?php

	include ("dbconnect.php");

	$actual_link = $_SERVER[HTTP_HOST];

	$link_array=explode('.',$actual_link);
	if ($link_array[0]==='www'){
		$site_image=$link_array[1];
	}else{
		$site_image=$link_array[0];
	}

// echo "site -> ".$site;

	unset($link_array);
	unset($actual_link);

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
		setcookie("site","finance");
$site="finance";
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

	<form name="welcome" method="GET" action="list.php">

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
						<td><img src="images/choose_country.png"></td>
						<td>

<?php

// create our first drop down box
//	echo ("<select NAME=\"cboCountryCode\" size=\"1\" onchange=\"this.form.submit()\">");
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
						<td><img src="images/choose_category.png"></td>
						<td>

<?php

// create the category drop-down
//	echo ("<select NAME=\"category\" size=\"1\" onchange=\"this.form.submit()\">");
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
						<td><input type="submit" id="search-submit" value="" style="background-image: url(images/search.png); border: solid 0px #000000; width: 139px; height: 28px;"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><img src="images/trans.gif" width="1" height="20"></td>
					</tr>
					<tr>
						<td><img src="images/add_your_website.png"></td>
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