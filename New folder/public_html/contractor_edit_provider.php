<head>
    <style type="text/css">
		body{
		    margin: 0;
		    padding: 0
		}
		* {
		    font-family: helvetica;
		    font-size:12px;
		}
    </style>

</head>

<body>

<?php

    function cleanInput($input) {

// create an array with the stuff we want to check for
	$search = array(
	    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
	    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
	    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
	    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);

// check the string for matches above
		$output = preg_replace($search, '', $input);

// pass the resulting string back to the SANITIZE function
		return $output;
	}

	function sanitize($input) {

// if the string is an array..
		if (is_array($input)) {

// check each array value
		    foreach($input as $var=>$val) {
				$output[$var] = sanitize($val);
		    }

// otherwise..
		}else{
		    if (get_magic_quotes_gpc()) {

// strip out back slashes
				$input = stripslashes($input);
		    }

// pass the string to the CLEANINPUT function for further processing
		    $input  = cleanInput($input);

// escapes special characters contained in the string such as ' or \
		    $output = mysql_real_escape_string($input);
	    }

// in case some muppet tries to add in SQL code it truncates the submitted string at the first semi-colon
	    $output = preg_replace('/\;.*/', '', $output);
	    $output = preg_replace('/=.*/', '', $output);

	    $output = str_replace('"', "", $output);

		return $output;
    }

// connect to the database
	include ("dbconnect.php");

// get the user ID associated with this hash - dont want to pass as a cookie value in case it might be spoofed
	$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// store the user ID for later
		$user_id=$row["user_id"];
	}
	
// sanitise the passed ID code just in case
	$provider_id=sanitize($_GET["provider_id"]);

// get the current time
	$time_now=time();

// check to see if the form has been submitted
	if ($_POST){

// sanitise the form inputs in case of suspect data
		$providername=sanitize($_POST["providername"]);
		$provideraddress=sanitize($_POST["provideraddress"]);
		$providercontact=sanitize($_POST["providercontact"]);
		$providerphone=sanitize($_POST["providerphone"]);
		$providermobile=sanitize($_POST["providermobile"]);
		$providerfax=sanitize($_POST["providerfax"]);
		$provideremail=sanitize($_POST["provideremail"]);
		$website=sanitize($_POST["website"]);
		$assoc_no=sanitize($_POST["assoc_no"]);
		$website=sanitize($_POST["website"]);
		$website_desc=sanitize($_POST["website_desc"]);
		$online=sanitize($_POST["online"]);
		$provider_id=sanitize($_POST["provider_id"]);
		$id=sanitize($_POST["id"]);

// make the changes to the provider record
		mysql_query("update provider set providername='".$providername."', provideraddress='".$provideraddress."', providercontact='".$providercontact."', providerphone='".$providerphone."', providermobile='".$providermobile."', providerfax='".$providerfax."', provideremail='".$provideremail."' where providerid='".$provider_id."';");

// as website data is, for whever reason(???), kept seperately fromt he provider record we need to update that that well
		mysql_query("update website set WebSite='".$website."', WebSiteDescr='".$website_desc."', online='".$online."' where ProviderID='".$id."';");
		
// update the user log
	    mysql_query("insert into user_log set user_id='".$user_id."', action='PROVIDER ".$provider_id." EDITED', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");

		echo ("<script>");
		echo ("self.close();");
		echo ("window.onunload = refreshParent;");
		echo ("function refreshParent() {");
		echo ("window.opener.location.reload();");
		echo ("}");
		echo ("</script>");
	}

// create the form
	echo ("<form name=\"update_provider\" method=\"POST\" action=\"contractor_edit_provider.php\">\n");

// create a table to hold the data
	echo ("<table>\n");
	echo ("<tr>\n");
	echo ("<td valign=\"top\" width=\"35%\">\n");
	echo ("<font face=\"arial\" size=\"-1\"><b>Instructions</b><p>You can edit some aspects of your providers here.<p>The site colour will default to blue unless you decide to change it.<p>Note that alterations will take effect immediateley and will be logged for later review.</b></font>\n");
	echo ("</td>\n");
 	echo ("<td><img src=\"images/trans.gif\" width=\"20\" height=\"1\"></td>\n");
	echo ("<td valign=\"top\"><table>\n");

// grab the sites details where the provider_id equals that chosen on the main screen
	$query="select * from provider where providerid='".$provider_id."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// sanitise the data returned from the database as I dont trust it at all
    	$row["providername"]=sanitize($row["providername"]);
    	$row["provideraddress"]=sanitize($row["provideraddress"]);
    	$row["providercontact"]=sanitize($row["providercontact"]);
    	$row["providerphone"]=sanitize($row["providerphone"]);
    	$row["providermobile"]=sanitize($row["providermobile"]);
    	$row["providerfax"]=sanitize($row["providerfax"]);
    	$row["provideremail"]=sanitize($row["provideremail"]);

// create the form
    	echo ("<input type=\"hidden\" name=\"id\" value=\"".$row["id"]."\">");
    	echo ("<input type=\"hidden\" name=\"provider_id\" value=\"".$row["providerid"]."\">");
    	echo ("<tr>\n<td width=\"100\">Name</td>\n<td><input type=\"text\" name=\"providername\" value=\"".$row["providername"]."\" size=\"35\"></td>\n</tr>\n");
    	echo ("<tr>\n<td>Address</td><td><input type=\"text\" name=\"provideraddress\" value=\"".$row["provideraddress"]."\" size=\"35\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Contact</td><td><input type=\"text\" name=\"providercontact\" value=\"".$row["providercontact"]."\" size=\"35\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Phone</td><td><input type=\"text\" name=\"providerphone\" value=\"".$row["providerphone"]."\" size=\"35\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Mobile</td><td><input type=\"text\" name=\"providermobile\" value=\"".$row["providermobile"]."\" size=\"35\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Fax</td><td><input type=\"text\" name=\"providerfax\" value=\"".$row["providerfax"]."\" size=\"35\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>E-Mail</td><td><input type=\"text\" name=\"provideremail\" value=\"".$row["provideremail"]."\" size=\"35\"><td>\n</tr>\n");

// grab the (inexplicably) seperated data from another table
    	$query2="select * from website where ProviderID='".$row["id"]."';";
	    $result2=mysql_query($query2);
	    while ($row2 = mysql_fetch_array($result2)) {

// create and sanitise variables for each
	    	$website=sanitize($row2["WebSite"]);
	    	$website_desc=sanitize($row2["WebSiteDesc"]);
	    	$online=sanitize($row2["online"]);
	    }

    	echo ("<tr>\n<td>Website</td><td><input type=\"text\" name=\"website\" value=\"".$website."\" size=\"30\"><a href=\"http://".$website."\" target=\"_new\"><img src=\"images/globe.png\" border=\"0\"></a><td>\n</tr>\n");
    	echo ("<tr>\n<td>Website Desc.</td><td><input type=\"text\" name=\"website_desc\" value=\"".$website_desc."\" size=\"35\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Online</td><td>");

		echo ("<select name=\"online\">\n");
		echo ("<option>Is this site online</option>\n");
		echo ("<option value=\"yes\"");

		if ($online=="yes"){
			echo(" SELECTED");
		}

		echo (">Yes</option>\n");
		echo ("<option value=\"no\"");
		
		if (($online=="no")or($online==='')){
			echo(" SELECTED");
		}
		
		echo (">No</option>\n");
		echo ("</select>\n");
    	echo ("</td></tr>\n");
    }

    echo ("<tr>\n<td></td>\n<td align=\"left\"><input type=\"submit\" value=\"Update this Provider\"></td>\n</tr>\n");
    
    echo ("<tr>\n<td colspan=\"2\"><img src=\"images/trans.gif\" width=\"1\" height=\"15\"></td>\n</tr>\n");

    echo ("<tr>\n<td></td>\n<td align=\"left\"><a style=\"color: red\" href=\"contractor_mark_provider_for_deletion.php?provider_id=".$provider_id."\"><b>Mark this provier for deletion</b></a></td>\n</tr>\n");

    echo ("</table>\n");

    echo ("</form>");


?>

</body>