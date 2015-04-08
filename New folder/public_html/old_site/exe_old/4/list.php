<?php

	include ("dbconnect.php");

// create our variables
	$site='';
	$country_code='';
	$country_name='';
	$region='';
	$category='';
	$startswith='';

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

// set the SITE variable either from the cookie value or a passer parameter
	if (isset($_COOKIE["site"])){
		$site=$_COOKIE["site"];
	}else{
		setcookie("site",$_POST["site"]);
		$site=$_POST["site"];
	}

	$blue_buttons_array=array('10outof10financiers','everything-about-finance','financealist','financebestbuys','financewhoswho','thefinancesearchengine','top100infinance','worldsfinancedirectory','worldtourismsearchengines','a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine','allabouttourism');
	$yellow_buttons_array=array('1stclassfinanciers');
	$black_buttons_array=array('everythingforfinance','5starfinanciers','bestfinancebusinesses','everythingforfinance','thefinancespecialist','worldsfinanciers','thefinancehelpdesk');
	$white_buttons_array=array('all-about-finance');
	$red_buttons_array=array('financeencyclopedias','a-zoffinance');
	$green_buttons_array=array('none-yet');
	$darkblue_buttons_array=array('none-yet');

	if (in_array($site_image,$darkblue_buttons_array)){
		$button_colour="darkblue";
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

//	echo "<font face=\"arial\" size=\"-1\">Site - <b>".$site."</b> - Category - <b>".$category."</b> - Country - <b>".$country_name."</b> - Code - <b>".$country_code."</b> - Region - <b>".$region."</b></font><p>";

	$x=1;
	$string='';

	$query="select distinct(websiteid) as websiteid from websitecategory where categid='".$category."';";
//	echo "<b>".$query."</b>";
//	echo "query -> ".$query."<br>";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

		$string=$string."'".$row["websiteid"]."',";
		$x++;

	}
	
//	echo "string -> ".$string;

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

	$startswith=$_POST["startswith"];

?>

<html>
<head>
	<style type="text/css">
		a {text-decoration:none}
		a:hover{text-decoration:underline}
		a.white:link {color: #ffffff; font-weight: bold;}
		a.white:active {color: #ffffff; font-weight: bold;}
		a.white:visited {color: #ffffff; font-weight: bold;}
		a.white:hover {color: #ffffff; font-weight: bolder;}
	</style>

</head>
<body>

<center>

<table border="0" cellpadding="10">
	<tr>
		<td rowspan="3" valign="top">

<?php
	$filename="images/".$site_image."_logo.jpg"; 

	if (file_exists($filename)) {
		echo ("<img src=\"images/".$site_image."_logo.jpg\" height=\"80%\" width=\"80%\">");
	}else{
		echo ("<img src=\"images/missing_logo.jpg\" height=\"80%\" width=\"80%\">");
	}
?>

		</td>
		<td>

<?php
	$filename="images/".$site_image."_title_small.jpg"; 

	if (file_exists($filename)) {
		echo ("<img src=\"images/".$site_image."_title_small.jpg\">");
	}else{
		echo ("<font face=\"arial\" size=\"+4\">Welcome</font>");
	}
?>
		</td>
	</tr>
	<tr>
		<td>
			<table cellpadding="5">
				<tr>
					<td><img src="images/<?php echo $button_colour; ?>_home.png"></td>
					<td><img src="images/<?php echo $button_colour; ?>_listing.png"></td>
					<td><img src="images/<?php echo $button_colour; ?>_information.png"></td>
				</tr>
				<tr>
					<td><img src="images/<?php echo $button_colour; ?>_search.png"></td>
					<td><img src="images/<?php echo $button_colour; ?>_new_listing.png"></td>
					<td><img src="images/<?php echo $button_colour; ?>_existing_listing.png"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>

			<form name="listings" method="POST" action="list.php">

			<table cellpadding="5">
				<tr>
					<td><img src="images/<?php echo $button_colour; ?>_choose_country.png"></td>
					<td>

<?php

// create our first drop down box - it will autosubmit on a change

	echo ("<select NAME=\"cboCountryCode\" size=\"1\" id=\"cboCountryCode\" onchange=\"this.form.submit()\">");
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

?>

					</td>
				</tr>
				<tr>
					<td><img src="images/<?php echo $button_colour; ?>_choose_region.png"></td>
					<td>

<?php

	if (isset($country_name)){

		echo ("<select NAME=\"cboStateCode\" size=\"1\" id=\"cboStateCode\" onchange=\"this.form.submit()\">");
		echo ("<option value=\"\">Choose a state</option>");
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
				</tr>
				<tr>
					<td><img src="images/<?php echo $button_colour; ?>_choose_category.png"></td>
					<td>

<?php

// create the category drop-down
	echo ("<select NAME=\"category\" size=\"1\" id=\"category\" onchange=\"this.form.submit()\">");
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
    echo ("</select>");
        
?>

					</form></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center>
				<table width="100%"><center>
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
				</table>						
			</center>
		</td>
	</tr>
</table>

<?php

	echo ("<table width=\"80%\">");
	echo ("<tr>");
	echo ("<td width=\"250\"><font face=\"arial\"><b>Name</b></font></td>");
	echo ("<td width=\"*\"><font face=\"arial\"><b>Location</b></font></td>");
	echo ("<td width=\"250\"><font face=\"arial\"><b>Website</b></font></td>");
	echo ("</tr>");

	$rowcounter=0;

	if ($region=='all'){
		$query2="select providerid, providername, sitekey, providercity, providerstatecode from provider where providerid in (".$string2.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey = '".strtoupper($site)."' and 
			providercountrycode = '".$country_code."'";
	}else{
		$query2="select providerid, providername, sitekey, providercity, providerstatecode from provider where providerid in (".$string2.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey = '".strtoupper($site)."' and 
			providerstatecode='".$region."' and 
			providercountrycode = '".$country_code."'";
	}

	if (isset($_POST["startswith"])){
		$query2=$query2." and providername like '".$startswith."%';";
	} else {
		$query2=$query2.";";
	}

//	echo $query2;
	
	$result2=mysql_query($query2);
	while ($row2 = mysql_fetch_array($result2)) {

		if ($rowcounter%2==0){
			$bgcolor="#EDF6F9";
		}else{
			$bgcolor="#DCE5E8";
		}

		echo ("<tr><td width=\"350\" bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2["providername"]."</font></td><td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">");

		if ($row2["providercity"]==''){
			echo $row2["providerstatecode"].", ".$country_code;
		}else{
			echo $row2["providercity"].", ".$row2["providerstatecode"].", ".$country_code;
		}

		$query3=mysql_query("select website from website where providerid='".$row2["providerid"]."';");
		$row3 = mysql_fetch_row($query3);

		echo ("</font></td><td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\"><a href=\"http://".$row3[0]."\" target=\"_new\">".$row3[0]."</a></font></tr>\n");
	
		$rowcounter++;

	}

	echo ("</table><p>");
?>

<font face="arial" size="-1"><b>A Member of the World Finance Search Engines' "Top 20" Global Finance Search Directories</b><p>

The finance pages, finance listings, finance links and internet finance directories are prepared by www.worldfinancesearchengines.com<br>under the Business Name "World Finance Search Engines " BN21003832 as a finance industry service.<p>

Please send updates and corrections to brian@worldfinancesearchengines.com.<br>
If you find any finance web pages, or finance link for any entry is not working, please also send us an email so we can contact the business and make the finance list totally reliable.<p>

To view "World's Finance Search Engine" consumer finance website please visit www.worldfinancesearchengines.com.<p>

<table>
	<tr>
		<td><font face="arial" size="-1">About Us</font></td>
		<td><font face="arial" size="-1">For More Information</font></td>
		<td><font face="arial" size="-1">Terms and Conditions</font></td>
		<td><font face="arial" size="-1">Powered by Chungara Solutions</font></td>
		<td><font face="arial" size="-1">Copyright</font></td>
	</tr>
</table><p>

<table>
	<tr>
		<td><font face="arial" size="-1">www.TheFinanceToolKit.com</font></td>
		<td><font face="arial" size="-1">www.10outof10Financiers.com</font></td>
		<td><font face="arial" size="-1">www.1stClassFinanciers.com</font></td>
	</tr>
		<td><font face="arial" size="-1">www.5StarFinanciers.com</font></td>
		<td><font face="arial" size="-1">www.All-About-Finance.com</font></td>
		<td><font face="arial" size="-1">www.A-ZofFinance.com</font></td>
	</tr>
	<tr>
		<td><font face="arial" size="-1">www.BestFinanceBusinesses.com</font></td>
		<td><font face="arial" size="-1">www.Everything-About-Finance.com</font></td>
		<td><font face="arial" size="-1">www.EverythingForFinance.com</font></td>
	</tr>
	<tr>
		<td><font face="arial" size="-1">www.FinanceBestBuys.com</font></td>
		<td><font face="arial" size="-1">www.FinanceEncyclopedias.com</font></td>
		<td><font face="arial" size="-1">www.FinanceAList.com</font></td>
	</tr>
	<tr>
		<td><font face="arial" size="-1">www.FinanceWhosWho.com</font></td>
		<td><font face="arial" size="-1">www.TheFinanceHelpDesk.com</font></td>
		<td><font face="arial" size="-1">www.TheFinanceSearchEngine.com</font></td>
	</tr>
	<tr>
		<td><font face="arial" size="-1">www.TheFinanceSpecialist.com</font></td>
		<td><font face="arial" size="-1">www.Top100inFinance.com</font></td>
		<td><font face="arial" size="-1">www.WorldsFinanceDirectory.com</font></td>
	</tr>
	<tr>
		<td></td>
		<td><font face="arial" size="-1">www.WorldsFinanciers.com</font></td>
		<td></td>
	</tr>
</table>

</body></html>