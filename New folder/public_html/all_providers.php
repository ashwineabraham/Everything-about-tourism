<head>
    <script>
		function CenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
	            var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
	            var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);

	            var misc_features;
	            if (features) {
	                misc_features = ', ' + features;
	            }
	            else {
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
	    font-size: 12;
	}

	form {
	    margin:0;
	    padding:0;
	    display:inline;
	}

	a.mainNav:link    {
		/* Applies to unvisited links of class mainNav */
		text-decoration:  none;
		color:            black;
		} 
	a.mainNav:visited {
		/* Applies to visited links of class mainNav */
		text-decoration:  none;
		color:            black;
		} 
	a.mainNav:hover   {
		/* Applies to links under the pointer of class mainNav */
		font-weight:      bold;
		text-decoration:  none;
		color:            black;
		} 
	a.mainNav:active  {
		/* Applies to activated links of class mainNav */
		text-decoration:  none;
		color: black;
		} 
    </style>
</head>

<body>

<table cellpadding="10">

	<tr>
		<td valign="top" width="300">

<?php

// connect to the database
    include ("dbconnect.php");

// get the current time stamp
    $time_now=time();

// get the user ID associated with this hash - dont want to pass as a cookie value in case it might be spoofed
    $query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// store the user ID for later
	$user_id=$row["user_id"];

// get the users first name
	$first_name=mysql_result(mysql_query("select firstname from authorised_users where id='".$user_id."';"),0);

// get the users designated country
	    $query1="select country_represented, sitekey_represented from authorised_users where id='".$user_id."';";
	    $result1=mysql_query($query1);
	    while ($row1 = mysql_fetch_array($result1)) {

		$sitekey_represented=$row1["sitekey_represented"];
		    
		    $query2="select country_name from countries where country_code='".$row1["country_represented"]."';";
		    $result2=mysql_query($query2);
		    while ($row2 = mysql_fetch_array($result2)) {
			$full_country_name=$row2["country_name"];
		    }
		    
// greeting text
    		echo "Welcome ".$first_name."<br>Representitive for ".$sitekey_represented." in ".$full_country_name."<p>";

		if (isset($_GET["country_chosen"])){
		    $country_represented=$_GET["country_chosen"];
		    $different_country_chosen="yes";
		    
		    $query2="select country_name from countries where country_code='".$_GET["country_chosen"]."';";
		    $result2=mysql_query($query2);
		    while ($row2 = mysql_fetch_array($result2)) {
			$full_country_name=$row2["country_name"];
		    }
	    
		}else{
		    $country_represented=$row1["country_represented"];
		}
		
	    }

// update the user log
    	mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='ACCESS ALL PROVIDERS PAGE', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");

	}

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
    $query="select site_key from site_details where site_name='".$site_name."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	$sitekey=$row["site_key"];
    }
	
	if (isset($different_country_chosen)){
	    echo ("Viewing providers in <b>".$full_country_name."</b><p>");
	}

// count the number of providers in this realm
    $query="select country_code from countries where country_name = '".$country_represented."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
		$country_code=$row["country_code"];
	}

	if ($user_id="3"){
	    
	    echo ("<form name=\"country_select\" method=\"GET\" action=\"all_providers.php\" STYLE=\"margin: 0px; padding: 0px;\">");
	    echo ("<select name=\"country_chosen\"  onchange=\"this.form.submit()\">");
	    echo ("<option>Choose your country to review</option>\n");
	    
	    $query2="select distinct(providercountrycode) as providercountrycode from provider where sitekey='".$sitekey_represented."' and providercountrycode <> '' and providercountrycode is not null order by providercountrycode asc;";
	    $result2=mysql_query($query2);
	    while ($row2 = mysql_fetch_array($result2)) {
		$query3="select country_name from countries where country_code='".$row2["providercountrycode"]."'";
		$result3=mysql_query($query3);
		while ($row3 = mysql_fetch_array($result3)) {
		    $country_name=$row3["country_name"];
		}
		
		echo ("<option value='".$row2["providercountrycode"]."'>".$country_name." (".$row2["providercountrycode"].")</option>\n");
	    }
	    
	    echo ("</select>\n");
	    echo ("</form>");
	    
	}
// count the number of providers in this realm
//	$query1="select count(*) as provider_count from provider where sitekey = '".$sitekey."' and providercountrycode = '".$country_code."';";
//    $result1=mysql_query($query1);
//    while ($row1 = mysql_fetch_array($result1)) {
//		$provider_count=$row1["provider_count"];
//	}

// write out a quick note
//	echo $provider_count." sites in ".$sitekey."<p>Top 10 visited sites in ".$country_represented."<p>";

// grab the top 10 sites in this country from the visitor log
//	$query="select site, count(*) as counted from visitor_log where country like '%(".$country_represented.")' group by site order by counted desc limit 10;";
//	$result=mysql_query($query);
//	while ($row = mysql_fetch_array($result)) {

// write them out top to bottom
//		echo $row["site"]." (".$row["counted"].")<br>";
//	}

	echo ("<br><img src=\"images/trans.gif\" width=\"300\" height=\"1\"></td><td valign=\"top\">");

// create a counter
	$counter=0;
	
// get an alphabetical list of all businesses in this SITEKEY what are in the users domain
	$query="select providerid, id, providername from provider where sitekey = '".$sitekey_represented."' and providercountrycode like '".$country_represented."' and deletion_request <> 'yes' group by providername;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

    	$online=mysql_result(mysql_query("select online from website where ProviderID='".$row["id"]."';"),0);
//    	$website=mysql_result(mysql_query("select WebSite from website where ProviderID='".$row["id"]."';"),0);

// check if the returned business name is only numbers and if so disregard it - this is a database cleanliness issue I wont get into here
		if (!ctype_digit($row["providername"])){
			
// get the first letter of the business name 
			$firstchar=$row["providername"][0];
			
// make it uppercase as some are lowercase and this throws the detector below
			$firstchar=strtoupper($firstchar);
			
// if the current starting letter os different to the previous then..
			if ($firstchar!==$lastchar){
				
// add a paragraph and an anchor to suit
				echo ("<p><a name=\"".$firstchar."\"><a href=\"#start\">Back to the start</a><p>");
			}
			
// truncate the really long names
			$providername= (strlen($row["providername"]) > 30) ? substr($row["providername"],0,27).'...' : $row["providername"];

		    if ($online=="yes"){
//	    		echo ("<a href=\"".$website."\" target=\"_BLANK\"><img src=\"images/tick.png\" border=\"0\"></a>");
	    		echo ("<img src=\"images/tick.png\" border=\"0\">");
			} else {
//	    		echo ("<a href=\"".$website."\" target=\"_BLANK\"><img src=\"images/tick.png\" border=\"0\"></a>");
	    		echo ("<img src=\"images/cross.png\" border=\"0\">");
		    }

// if it passes the mixed character test then write it out
			echo ("<a class=\"mainNav\" href=\"javascript:void(0)\" onclick=\"CenterWindow(500,400,50,'contractor_edit_provider.php?provider_id=".$row["providerid"]."','Provider Details');\">".$providername."</a><br>\n");
			
// increment the counter
			$counter++;
			
// something something...?
			$lastchar=$firstchar;
		}
		
// if the counter has reached 30
		if ($counter===30){
			
// if so then start a new column
			echo ("<img src=\"images/trans.gif\" width=\"250\" height=\"1\"></td><td valign=\"top\" width=\"250\">");
			
// reset the counter to zero
			$counter=0;
		}
	}

?>

		<img src="images/trans.gif" width="250" height="1"></td>
	</tr>
</table>

</body>