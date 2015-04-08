<?php

	include ("dbconnect.php");

// create our variables
	$site='';
	$country_code='';
	$country_name='';
	$region='';
	$category='';
	$startswith='';

//    $finance_sitename_array=array('worldfinancesearchengines','worldfinancesearchengine','thefinancetoolkit','10outof10financiers','1stclassfinanciers','5starfinanciers','all-about-finance','a-zoffinance','bestfinancebusinesses','everything-about-finance','everythingforfinance','financebestbuys','financeencyclopedias','financealist','financewhoswho','thefinancehelpdesk','thefinancesearchengine','thefinancespecialist','top100infinance','worldsfinancedirectory','worldsfinanciers');
//    $disability_sitename_array=array('a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine');
//    $tourism_sitename_array=array('allabouttourism','atozoftourism','besttourismbusinesses','everythingabouttourism','top100intourism','tourismalist','tourismbestbuys','tourismsearchengine','whoswhointourism','worldstourismdirectory','worldtourismsearchengine');

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

	$getdataarray=explode("&",$getdata[1]);

	$urlstring=$getdataarray[0]."&".$getdataarray[1]."&".$getdataarray[2];

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


  //       .table1 {
		// 	background: rgba(255,255,255,0.5);
		// 		/* for IE */
		// 	filter:alpha(opacity=60);
		//    /* CSS3 standard */
		// 	opacity:0.6;
		// }

?>

<html>
<head>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0
        }

        @font-face {
            font-family: Titillium;
            src: url('Titillium-Regular.otf');
        }

        @font-face {
            font-family: Titillium;
            font-weight: bold;
            src: url('Titillium-Bold.otf');
        }

        h1{
            font-family: Titillium;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
	        text-shadow: 3px 3px 2px rgba(150, 150, 150, 0.7);
			font-size: 52px;
        }

        .stretch {
            background-image: url('<?php echo $choose_wallpaper; ?>');
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        
        * {
            font-family: helvetica;
        }
        
        .btn {
            background: <?php echo $colour1; ?>;
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

	switch ($site){
		case "finance":
			echo ("<body link=\"#822a25\" alink=\"#822a25\" vlink=\"#822a25\">");
			break;
		case "tourism":
			echo ("<body link=\"#005186\" alink=\"#005186\" vlink=\"#005186\">");
			break;
		default:
			echo ("<body link=\"#005186\" alink=\"#005186\" vlink=\"#005186\">");
			break;
	}

?>

<center>

<table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td height="164" background="<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#ffffff"><img src="trans.gif" width="2" height="2"></td>
                </tr>
                <tr>
                    <td valign="middle"><h1><?php echo $site_title; ?></h1></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff"><img src="trans.gif" width="2" height="2"></td>
                </tr>
            </table></center>
        </td>
    </tr>
    <tr>
        <td height="100%" class="stretch" valign="top">
            <center>

            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td><img src="trans.gif" width="1" height="10"></td>
                </tr>
                <tr>
                    <td><img src="fade_left_<?php echo $site_colour; ?>.png"></td>
                    <td background="fade_middle_<?php echo $site_colour; ?>.gif"> <a href="new_listing.php"   style="text-decoration:none;"><font color="#ffffff">Add Your Website</font></a> </td>
                    <td><img src="fade_right_<?php echo $site_colour; ?>.png"></td>
                </tr>
                <tr>
                    <td><img src="trans.gif" width="1" height="10"></td>
                </tr>
            </table>

			<form name="listings" method="POST" action="list.php">

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
		echo $query;
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
//	echo ("<select NAME=\"category\" size=\"1\">");
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
        
?>

<!--				<table width="100%"><center>
					<tr>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>" class="white">All</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=0" class="white">0-9</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=A" class="white">A</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=B" class="white">B</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=C" class="white">C</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=D" class="white">D</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=E" class="white">E</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=F" class="white">F</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=G" class="white">G</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=H" class="white">H</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=I" class="white">I</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=J" class="white">J</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=K" class="white">K</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=L" class="white">L</a></font></center></td>
					</tr>						
					<tr>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=M" class="white">M</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=N" class="white">N</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=O" class="white">O</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=P" class="white">P</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=Q" class="white">Q</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=R" class="white">R</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=S" class="white">S</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=T" class="white">T</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=U" class="white">U</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=V" class="white">V</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=W" class="white">W</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=X" class="white">X</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=Y" class="white">Y</a></font></center></td>
						<td width="7%" bgcolor="#006699"><center><font face="arial" color="#ffffff"><a href="list.php?<?php echo $urlstring; ?>&startswith=Z" class="white">Z</a></font></center></td>
					</tr>
				</table> -->					

<?php

	echo ("<table width=\"80%\" class=\"table1\" cellpadding=\"4\" cellspacing=\"1\">");
	echo ("<tr>");
	echo ("<td bgcolor=\"#ffffff\" width=\"250\"><font face=\"arial\" colour=\"yellow\"><b>Name</b></font></td>");
	echo ("<td bgcolor=\"#ffffff\" width=\"*\"><font face=\"arial\" colour=\"yellow\"><b>Location</b></font></td>");
	echo ("<td bgcolor=\"#ffffff\"></td>");
	echo ("<td bgcolor=\"#ffffff\" width=\"250\"><font face=\"arial\" colour=\"yellow\"><b>Website</b></font></td>");
	echo ("</tr>");

	$rowcounter=0;

	if ($region=='all'){
		$query2="select providerid, id, providername, sitekey, providercity, providerstatecode from provider where id in (".$string2.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey like '".strtoupper($site)."' and 
			providercountrycode = '".$country_code."'";
	}else{
		$query2="select providerid, id, providername, sitekey, providercity, providerstatecode from provider where id in (".$string2.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey like '".strtoupper($site)."' and 
			providerstatecode='".$region."' and 
			providercountrycode = '".$country_code."'";
	}

	if (isset($_POST["startswith"])){
		$query2=$query2." and providername like '".$startswith."%';";
	} else {
		$query2=$query2.";";
	}

	$result2=mysql_query($query2);
	while ($row2 = mysql_fetch_array($result2)) {

// on Peters request the rows are plain white however I kept the rotation code jsut in case
		if ($rowcounter%2==0){
			$bgcolor="#ffffff";
		}else{
			$bgcolor="#ffffff";
		}

		echo ("<tr><td width=\"350\" bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2["providername"]."</font></td><td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">");

		if ($row2["providercity"]==''){
			echo $row2["providerstatecode"].", ".$country_code;
		}else{
			echo $row2["providercity"].", ".$row2["providerstatecode"].", ".$country_code;
		}

		$query3=mysql_query("select website, online from website where providerid='".$row2["id"]."';");
		$row3 = mysql_fetch_row($query3);

		echo ("</font></td>");

		if ($row3[1]=='yes'){
			echo ("<td bgcolor=\"#D3EBC7\" width=\"16\"><img src=\"images/tick.png\"></td>");
		}else{
			echo ("<td bgcolor=\"#E8CAAF\" width=\"16\"><img src=\"images/cross.png\"></td>");
		}

		echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\"><a href=\"http://".$row3[0]."\" target=\"_new\">".$row3[0]."</a></font></tr>\n");
	
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
				<td colspan="3" bgcolor="#ffffff"><img src="images/trans.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
			</tr>
			<tr>
				<td valign="top" align="left" width="200"><font color="#ffffff" size="-1">Contact Us</font></td>
				<td valign="top" align="center" width="100%"></td>
				<td valign="top" align="right"><font color="#ffffff" width="200" size="-1">(c) <?php echo $site_title; ?><br>ABN 1234567890</font></td>
			</tr>
			<tr>
				<td><img src="images/trans.gif" width="200" height="10"></td>
				<td></td>
				<td><img src="images/trans.gif" width="200" height="10"></td>
			</tr>
			<tr>
				<td colspan="3"><center>
					<font color="#ffffff" size="-1">A Member of the World Finance Search Engines' "Top 20" Global Finance Search Directories<p>
					<b>The finance pages, finance listings, finance links and internet finance directories are prepared by www.worldfinancesearchengines.com under the Business Name "World Finance Search Engines " BN21003832 as a finance industry service.<br>
					Please send updates and corrections to <a href="mailto:brian@worldfinancesearchengines.com">brian@worldfinancesearchengines.com</a>.<p>
					If you find any finance web pages, or finance link for any entry is not working, please also send us an email so we can contact the business and make the finance list totally reliable. To view "World's Finance Search Engine" consumer finance website please visit <a href="http://www.worldfinancesearchengines.com/" target="_new">www.worldfinancesearchengines.com</a></font>.
				</td>
			</tr>

		</table>
	</td>
</tr>


	</table>
</body>
</html>