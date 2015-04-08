<?php

// connect to the database
	include ("dbconnect.php");

// create our variables
	$site='';
	$country_code='';
	$country_name='';
	$region='';
	$category='';
	$startswith='';

// get the URL requested by the client
	$actual_link = $_SERVER["HTTP_HOST"];

// deconstruct the URL using the "." as a delimter
	$link_array=explode('.',$actual_link);

// if the first array value is "www"..
	if ($link_array[0]==='www'){

// then use the second array value to test with
		$site_name=$link_array[1];
	}else{

// otherwise the www is issing and the first array value holds the site name
		$site_name=$link_array[0];
	}

// set the SITE variable either from the cookie value or a passer parameter
	if (isset($_COOKIE["site"])){
		$site=$_COOKIE["site"];
	}else{
		setcookie("site",$_POST["site"]);
		$site=$_POST["site"];
	}

// if the COUNTRY variable has been passed then
	if (isset($_POST["cboCountryCode"])){

// set a cookie with that value
		setcookie("cboCountryCode",$_POST["cboCountryCode"]);

// set the COUNTRY_CODE variable to the passed variable - this will be a two character code such as AU
		$country_code=$_POST["cboCountryCode"];
		
// get the full country name for the passed country code and set it as a variablw
		$query="select country_name from countries where country_code='".$country_code."';";
		$result=mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			setcookie("cboCountryName",$row["country_name"]);
			$country_name=$row["country_name"];
		}
	}

// if the state variable has been passed set the cookie and a variable to suit
	if (isset($_POST["cboStateCode"])){
		setcookie("cboStateCode",$_POST["cboStateCode"]);
		$region=$_POST["cboStateCode"];
	} else {
		setcookie("cboStateCode","all");
		$region="all";
	}

// if the category variable has been passed set the cookie and a variable to suit
	if (isset($_POST["category"])){
		setcookie("category",$_POST["category"]);
		$category=$_POST["category"];
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

	$x=1;
	$string='';

	$query="select distinct(websiteid) as websiteid from websitecategory where categid='".$category."';";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$string=$string."'".$row["websiteid"]."',";
		$x++;
	}
	
	$string=rtrim($string, ",");
 	$string2='';

	$query="select providerid from website where websiteid in (".$string.");";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$string2=$string2."'".$row["providerid"]."',";
	}

	$string2=rtrim($string2, ",");

// read out fully URL including passed parameters
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// ditch the URL and keep the data in $getdata[1]
	$getdata=explode("?", $actual_link);

	$getdataarray=explode("&",$getdata["1"]);

	$urlstring=$getdataarray["0"]."&".$getdataarray["1"]."&".$getdataarray["2"];

	$site_key=ucfirst($site_key);
	$site_colour=ucfirst($site_colour);
// pick a random number
    $choose_wallpaper=rand(1,5);
    $choose_wallpaper=$site_key."_".$site_colour."_".$choose_wallpaper.".jpg";

    $colour1='';
    $colour2='';

//echo $site_colour;
    switch ($site_colour){
        case "Red":
            $colour1='#d35543';
            $colour2='#822a25';
            break;
        case "Blue":
            $colour1='#1178b1';
            $colour2='#005186';
            break;
        case "Green":
            $colour1='#339900';
            $colour2='#267200';
    }

   $site_colour=strtolower($site_colour);

?>
<html>

<head>

    <title><?php echo $site_title; ?></title>

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

        .stretch {
            background-image: url('http://www.<?php echo $site_name; ?>.com/images/<?php echo $choose_wallpaper; ?>');
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-color: <?php echo $colour1; ?>;
        }
        
        * {
            font-family: helvetica;
        }

        .btn {
            background: <?php echo $colour2; ?>;
            background-image: -webkit-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -o-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: linear-gradient(to bottom, <?php echo $colour1.",".$colour2; ?>);
            -webkit-border-radius: 4;
            -moz-border-radius: 4;
            border-radius: 4px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 5px 10px 5px 10px;
            text-decoration: none;
        }

    </style>

</head>

<?php

	$site=$_COOKIE["site"];

	echo ("<body link=\"#ffffff\" alink=\"#ffffff\" vlink=\"#ffffff\" onload=\"init()\">");

?>

<div id="loading" style="position:absolute; width:100%; text-align:center; top:300px;display:inline;">
<img src="images/loading_animation2.gif" border=0></div>

<script>
 var ld=(document.all);
  var ns4=document.layers;
 var ns6=document.getElementById&&!document.all;
 var ie4=document.all;
  if (ns4)
 	ld=document.loading;
 else if (ns6)
 	ld=document.getElementById("loading").style;
 else if (ie4)
 	ld=document.all.loading.style;
  function init()
 {
 if(ns4){ld.visibility="hidden";}
 else if (ns6||ie4) ld.display="none";
 }
 </script>

<center>

<table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td height="164" background="images/<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
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
        <td height="100%" class="stretch" valign="top">
            <center>

            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
                </tr>
                <tr>
                    <td><img src="images/fade_left_<?php echo $site_colour; ?>.png"></td>
                    <td background="images/fade_middle_<?php echo $site_colour; ?>.gif"> <a href="new_listing.php" style="text-decoration:none;"><font color="#ffffff">Add Your Website</font></a> </td>
                    <td><img src="images/fade_right_<?php echo $site_colour; ?>.png"></td>
                </tr>
                <tr>
                    <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
                </tr>
            </table>

			<form name="listings" method="POST" action="list2.php">

<?php

// create our first drop down box - it will autosubmit on a change
	echo ("<select NAME=\"cboCountryCode\" size=\"1\" id=\"cboCountryCode\" onchange=\"this.form.submit()\" class=\"btn\">");
	echo ("<option value=\"\">Choose a country</option>");
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

	if (isset($country_name)){

		echo (" <select NAME=\"cboStateCode\" size=\"1\" id=\"cboStateCode\" onchange=\"this.form.submit()\" class=\"btn\">");
		echo ("<option value=\"all\"");

		if ($region=='all'){
			echo (" selected");
		}

		echo (">Choose State/Region</option>");
		echo ("<option value=\"all\">== All ==</option>");

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

// create the category drop-down
	echo (" <select NAME=\"category\" size=\"1\" id=\"category\" onchange=\"this.form.submit()\" class=\"btn\">");
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
    echo ("</select></form>");

	echo ("<table width=\"80%\" class=\"table1\" cellpadding=\"4\" cellspacing=\"1\" border=\"1\">");
	echo ("<tr>");
	echo ("<td bgcolor=\"".$colour2."\" width=\"250\"><font face=\"arial\" color=\"yellow\"><b>Name</b></font></td>");
	echo ("<td bgcolor=\"".$colour2."\" width=\"*\"><font face=\"arial\" color=\"yellow\"><b>Location</b></font></td>");
	echo ("<td bgcolor=\"".$colour2."\" width=\"250\"><font face=\"arial\" color=\"yellow\"><b>Website</b></font></td>");
	echo ("</tr>");

// set the row counter to zero
	$rowcounter=0;

// region check for query choice - if ALL then show everything
	if ($region=='all'){
		$query2="select providerid, id, providername, sitekey, providercity, providerstatecode from provider where id in (".$string2.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey like '".strtoupper($site)."' and 
			providercountrycode = '".$country_code."'";

// otherwise show the chosen location
	}else{
		$query2="select providerid, id, providername, sitekey, providercity, providerstatecode from provider where id in (".$string2.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey like '".strtoupper($site)."' and 
			providerstatecode='".$region."' and 
			providercountrycode = '".$country_code."'";
	}

// if the user has selected a letter of the alphabet then add that option to the query
	if (isset($_POST["startswith"])){
		$query2=$query2." and providername like '".$startswith."%';";

// otherwise close it off
	} else {
		$query2=$query2.";";
	}

// perform the query
	$result2=mysql_query($query2);
	while ($row2 = mysql_fetch_array($result2)) {

// on Peters request the rows are plain white however I kept the rotation code just in case
		if ($rowcounter%2==0){
			$bgcolor="#ffffff";
		}else{
			$bgcolor="#ffffff";
		}

// replace "&" symbols with HTML equivilent if found
		$row2["providername"]=str_replace("&", "&amp;", $row2["providername"]);

// due to the design of the original database having the websites and the provider data kept seperately I have to postpose writing out the table line until we can confirm if the website is online or not
		$tablerow="<tr><td width=\"350\" bgcolor=\"".$colour2."\"><font face=\"arial\" color=\"#ffffff\" size=\"-1\"><b>".$row2["providername"]."</b></font></td><td bgcolor=\"".$colour2."\"><font face=\"arial\" color=\"#ffffff\" size=\"-1\"><b>";

// location data check to show best format for available data
		if ($row2["providercity"]==''){
			$tablerow=$tablerow.$row2["providerstatecode"].", ".$country_code;
		}else{
			$tablerow=$tablerow.$row2["providercity"].", ".$row2["providerstatecode"].", ".$country_code;
		}

// grab the website link and online status
		$query3=mysql_query("select website, online from website where providerid='".$row2["id"]."';");
		$row3 = mysql_fetch_row($query3);

// add those details to the table row
		$tablerow=$tablerow."</b></font></td><td bgcolor=\"".$colour2."\"><font face=\"arial\" color=\"#ffffff\" size=\"-1\"><a href=\"http://".$row3[0]."\" target=\"_blank\" style=\"text-decoration: none;\"><b>".$row3[0]."</b></a></font></td></tr>\n";

// only show the row if ONLINE = YES
		if ($row3[1]==='yes'){
			echo $tablerow;
		}
	
// increment the row counter
		$rowcounter++;

	}

?>

<tr>
	<td colspan="4">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="yellow"><img src="images/trans.gif" width="1" height="1"></td>
            </tr>
            <tr>
                <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
            </tr>
            <tr>
                <td valign="top" align="left" width="200"><font color="yellow" size="-1"><b><a href="contact_us.php" style="color:yellow">Contact Us</a></font></td>
                <td valign="top" align="center" width="100%"><center><font color="yellow" size="-1"><b><a href="about_us.php" style="color:yellow">About Us</a></font></center></td>
                <td valign="top" align="right" width="200" ><font color="yellow" size="-1"><b><a href="terms_and_conditions.php" style="color:yellow">Terms and Conditions</a><br>(c) <?php echo $site_title; ?></font></td>
            </tr>
            <tr>
                <td><img src="images/trans.gif" width="200" height="10"></td>
                <td></td>
                <td><img src="images/trans.gif" width="200" height="10"></td>
            </tr>
                <td colspan="3"><center>
                    <font color="yellow" size="-1"><b>A Member of the World Finance Search Engines' "Top 20" Global Finance Search Directories</b></font><br>
                    <font color="yellow" size="-1"><b>The finance pages, finance listings, finance links and internet finance directories are prepared by www.worldfinancesearchengines.com under the Business Name "World Finance Search Engines" as a finance industry service.</b></font><br>
                    <font color="yellow" size="-1"><b>Please send updates and corrections to <a href="mailto:manager@worldfinancesearchengines.com" style="color:yellow">manager@worldfinancesearchengines.com</a>.</b></font><br>
                    <font color="yellow" size="-1"><b>If you find any finance web pages, or finance link for any entry is not working, please also send us an email so we can contact the business and make the finance list totally reliable. <!-- To view "World's Finance Search Engine" consumer finance website please visit <a href="http://www.worldfinancesearchengines.com/" target="_blank">www.worldfinancesearchengines.com</a> --></b></font>.</center>
                </td>
        </table>
	</td>
</tr>


	</table>
</body>
</html>

<script language="javascript">
     interstitial.style.display="none";
</script>
