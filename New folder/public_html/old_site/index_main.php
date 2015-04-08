<head>
	
	<script>
		function CenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
			var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
			var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);
		
			var misc_features;
			if (features) {
				misc_features = ', ' + features;
			} else {
				misc_features = ', status=no, location=no, scrollbars=yes, resizable=no';
			}
			var windowFeatures = 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + centerLeft + ',top=' + centerTop + misc_features;
			var win = window.open(url, wname, windowFeatures);
			win.focus();
			return win;
		}
	</script>

	<style type="text/css">
		* {
		    font-family: helvetica;
		}

		.big_button {
			-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
			-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
			box-shadow:inset 0px 1px 0px 0px #bbdaf7;
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
			background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
			background-color:#79bbff;
			-webkit-border-top-left-radius:6px;
			-moz-border-radius-topleft:6px;
			border-top-left-radius:6px;
			-webkit-border-top-right-radius:6px;
			-moz-border-radius-topright:6px;
			border-top-right-radius:6px;
			-webkit-border-bottom-right-radius:6px;
			-moz-border-radius-bottomright:6px;
			border-bottom-right-radius:6px;
			-webkit-border-bottom-left-radius:6px;
			-moz-border-radius-bottomleft:6px;
			border-bottom-left-radius:6px;
			text-indent:0;
			border:1px solid #84bbf3;
			display:inline-block;
			color:#ffffff;
			font-family:Arial;
			font-size:12px;
			font-weight:bold;
			font-style:normal;
			height:30px;
			line-height:30px;
			width:100px;
			text-decoration:none;
			text-align:center;
			text-shadow:1px 1px 0px #528ecc;
		}

		.big_button:hover {
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
			background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
			background-color:#378de5;
		}

		.big_button:active {
			position:relative;
			top:1px;
		}

		.big_select {
			-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
			-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
			box-shadow:inset 0px 1px 0px 0px #bbdaf7;
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
			background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
			background-color:#79bbff;
			-webkit-border-top-left-radius:6px;
			-moz-border-radius-topleft:6px;
			border-top-left-radius:6px;
			-webkit-border-top-right-radius:6px;
			-moz-border-radius-topright:6px;
			border-top-right-radius:6px;
			-webkit-border-bottom-right-radius:6px;
			-moz-border-radius-bottomright:6px;
			border-bottom-right-radius:6px;
			-webkit-border-bottom-left-radius:6px;
			-moz-border-radius-bottomleft:6px;
			border-bottom-left-radius:6px;
			text-indent:0;
			border:1px solid #84bbf3;
			display:inline-block;
			color:#ffffff;
			font-family:Arial;
			font-size:12px;
			font-weight:bold;
			font-style:normal;
			height:30px;
			line-height:30px;
			width:100px;
			text-decoration:none;
			text-align:center;
			text-shadow:1px 1px 0px #528ecc;
		    padding: 5px 5px 5px 5px;
		}

		.big_select:hover {
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
			background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
			background-color:#378de5;
		}

/* This button was generated using CSSButtonGenerator.com*/

	</style>

</head>

<body>
	
<?php

	function getUserIP()
	{
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

	    return $ip;
	}

	$finance_sitename_array=array('worldfinancesearchengines','thefinancetoolkit','10outof10financiers','1stclassfinanciers','5starfinanciers','all-about-finance','a-zoffinance','bestfinancebusinesses','everything-about-finance','everythingforfinance','financebestbuys','financeencyclopedias','financealist','financewhoswho','thefinancehelpdesk','thefinancesearchengine','thefinancespecialist','top100infinance','worldsfinancedirectory','worldsfinanciers');
	$disability_sitename_array=array('a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine');
	$tourism_sitename_array=array('allabouttourism','atozoftourism','besttourismbusinesses','everythingabouttourism','top100intourism','tourismalist','tourismbestbuys','tourismsearchengine','whoswhointourism','worldstourismdirectory');

	$blue_buttons_array=array('worldfinancesearchengines','10outof10financiers','everything-about-finance','financealist','financebestbuys','financewhoswho','everythingabouttourism','thefinancesearchengine','top100infinance','worldsfinancedirectory','worldtourismsearchengines','a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine','allabouttourism');
	$yellow_buttons_array=array('1stclassfinanciers');
	$black_buttons_array=array('everythingforfinance','5starfinanciers','bestfinancebusinesses','everythingforfinance','thefinancespecialist','worldsfinanciers','thefinancehelpdesk');
	$white_buttons_array=array('all-about-finance');
	$red_buttons_array=array('financeencyclopedias','a-zoffinance');
	$green_buttons_array=array('none-yet');
	$darkblue_buttons_array=array('none-yet');

// set the expiration date to one hour ago
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
//		$site_image="1stclassfinanciers";
	}else{

// otherwise the www is issing and the first array value holds the site name
		$site_image=$link_array[0];
//		$site_image="1stclassfinanciers";
	}
	
	$ip_address=getUserIP();

//	echo ("<font color=\"#ffffff\">".$ip_address."</font><br>");
	
//	$ip_address_proxy=$_SERVER['HTTP_X_FORWARDED_FOR'];
	
	$timenow=time();
	

	$country=file_get_contents("http://freegeoip.net/json/".$ip_address);

//	echo ("<font color=\"#ffffff\">".$country."</font>");


//	$country = shell_exec('curl http://api.ipinfodb.com/v3/ip-country/?key=2cce8cb49bc1dd3943a31fb4f528a395f3ddf352a47a0c71877612afceb99914&ip=".$ip_address."');
// echo ("curl http://api.ipinfodb.com/v3/ip-country/?key=2cce8cb49bc1dd3943a31fb4f528a395f3ddf352a47a0c71877612afceb99914&ip=".$ip_address." -> ".$country);

	$explode=explode(',',$country);

	$country_name_array=explode(':',$explode[2]);
	$country_name_full=$country_name_array[1];

	$country_code_array=explode(":",$explode[1]);
	$country_code_full=$country_code_array[1];

	$country=$country_name_full." (".$country_code_full.")";
	$country=str_replace('"', "", $country);

	mysql_query("insert into visitor_log set site='".$site_image."', ip_address='".$ip_address."', ip_address_proxy='".$ip_address_proxy."', country='".$country."', timestamp='".$timenow."';");

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
			$site="disability";
			setcookie("site","disability");
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
	if (in_array($site_image,$green_buttons_array)){
		$button_colour="green";
	}
	if (in_array($site_image,$darkblue_buttons_array)){
		$button_colour="darkblue";
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

<center>

	<form name="welcome" method="POST" action="list.php">

	<table cellpadding="10" cellspacing="10" border="0">
		<tr>
			<td rowspan="6">

<?php
	$filename="images/".$site_image."_logo.jpg"; 

	if (file_exists($filename)) {
		echo ("<img src=\"".$filename."\">");
	}else{
		echo ("<img src=\"images/missing_logo.jpg\">");
	}
?>

			</td>
			<td valign="top">
				<table>
					<tr>
						<td colspan="2">

<?php
	$filename="images/".$site_image."_title.jpg"; 

	if (file_exists($filename)) {
		echo ("<img src=\"images/".$site_image."_title.jpg\">");
	}else{
		echo ("<font face=\"arial\" size=\"+4\">Welcome</font>");
	}
?>

						</td>
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
						<td><a href="javascript:void(0)" onclick="CenterWindow(600,500,50,'new_listing.php','Add your website');"><img src="images/<?php echo $button_colour; ?>_add_your_website.png" border="0"></a></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</form>

<!-- <a href="#" class="big_button">TEXT</a><p>

<select name="test" class="big_select"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> -->

</center>
</body>
</html>