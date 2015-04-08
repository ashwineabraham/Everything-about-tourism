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
	    $output = preg_replace('/\"/', '', $output);
	    $output = preg_replace('/\?/', '', $output);
	    $output = preg_replace('/\\\/', '', $output);

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

// check to see if the form has been submitted
	if ($_POST){

// sanitise the form inputs in case of suspect data
		$category_id=sanitize($_POST["category_id"]);
		$providername=sanitize($_POST["providername"]);
		$provideraddress=sanitize($_POST["provideraddress"]);
		$providercity=sanitize($_POST["providercity"]);
		$providerpostal=sanitize($_POST["providerpostal"]);
		$providercountrycode=sanitize($_POST["providercountrycode"]);
		$providerphone=sanitize($_POST["providerphone"]);
		$providerfax=sanitize($_POST["providerfax"]);
		$providercontact=sanitize($_POST["providercontact"]);
		$website=sanitize($_POST["website"]);
		$websitedescription=sanitize($_POST["websitedescription"]);

// get the current timestamp
		$time_now=time();

// find the highest id in the providers table and add one to ensure a unique id code
		$query="select max(id) as max_id from provider;";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	$max_id=$row["max_id"]+1;
	    }

// grab and explode the site category data
		$query="select * from categories where category_id=\"".$category_id."\";";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	$site_key=$row["category_type"];
	    	$category_name=$row["category_name"];
	    }

	    echo ("insert into website set provider_id=\"".$max_id."\", website=\"".$website."\", websitedescription=\"".$websitedescription."\"<p>");

//echo out the temp query
		echo ("insert into provider set sitekey=\"".$site_key."\", providername=\"".$providername."\", provideraddress=\"".$provideraddress."\", providercity=\"".$providercity."\", providerpostal=\"".$providerpostal."\", providercountrycode=\"".$providercountrycode."\", providerphone=\"".$providerphone."\", providerfax=\"".$providerfax."\", providercontact=\"".$providercontact."\"<p>");

// make the changes to the provider record
//		echo ("<p>update provider set deletion_request='".$deletion_request."', deletion_request_reason='".$deletion_request_reason."', deletion_request_timestamp='".$time_now."' where providerid='".$provider_id."';");

// update the user log
//	    mysql_query ("insert into user_log set user_id='".$user_id."', action='PROVIDER ".$provider_id." DELETION REQUEST', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
	
//		echo ("<script>");
//		echo ("self.close();");
//		echo ("window.onunload = refreshParent;");
//		echo ("function refreshParent() {");
//		echo ("window.opener.location.reload();");
//		echo ("}");
//		echo ("</script>");
	}

// create the form
	echo ("<form name=\"add_free_listing\" action=\"contractor_add_free_listing.php\" method=\"POST\">");

// add a hidden variable for the provider_id
	echo ("<input type=\"hidden\" name=\"provider_id\" value=\"".$provider_id."\">");

// set up the table
	echo ("<table>");

// create a drop-down list of the site keys
	echo ("<tr>\n<td>Site Domain Category</td>\n<td>");

	echo ("<select name=\"category_id\"\>");
	echo ("<option>Choose a category</option>");

// pull all the unique SITEKEY strings to fill the drop-down menu 
	$query2="select * from categories where category_name not like '%?%' order by category_type, category_name asc;";
    $result2=mysql_query($query2);
    while ($row2 = mysql_fetch_array($result2)) {

		echo ("<option value=\"".$row2["category_id"]."\"");

// convert it back to uppercase for the combo box text
		$row2["category_type"]=strtoupper($row2["category_type"]);

		echo (">".$row2["category_type"]." - ".$row2["category_name"]."</option>\n");
	}

	echo ("</select></td></tr>");

// simple table of the remainder of the free listings
	echo ("<tr><td>Provider name</td><td><input type=\"text\" name=\"providername\" size=\"50\"></td></tr>");
	echo ("<tr><td>Address</td><td><input type=\"text\" name=\"provideraddress\" size=\"50\"></td></tr>");
	echo ("<tr><td>City</td><td><input type=\"text\" name=\"providercity\" size=\"50\"></td></tr>");
	echo ("<tr><td>Postal</td><td><input type=\"text\" name=\"providerpostal\" size=\"50\"></td></tr>");
	echo ("<tr><td>Province</td><td><input type=\"text\" name=\"prroviderprovince\" size=\"50\"></td></tr>");
	echo ("<tr><td>Country Code</td><td><input type=\"text\" name=\"providercountrycode\" size=\"50\"></td></tr>");
	echo ("<tr><td>Phone</td><td><input type=\"text\" name=\"providerphone\" size=\"50\"></td></tr>");
	echo ("<tr><td>Fax</td><td><input type=\"text\" name=\"providerfax\" size=\"50\"></td></tr>");
	echo ("<tr><td>Email</td><td><input type=\"text\" name=\"provideremail\" size=\"50\"></td></tr>");
	echo ("<tr><td>Contact name</td><td><input type=\"text\" name=\"providercontact\" size=\"50\"></td></tr>");
	echo ("<tr><td>Website address</td><td><input type=\"text\" name=\"website\" size=\"50\"></td></tr>");
	echo ("<tr><td>Website description</td><td><input type=\"text\" name=\"websitedescription\" size=\"50\"></td></tr>");

// write out the submit button
	echo ("<tr><td></td><td align=\"right\"><input type=\"submit\" value=\"Add a free listing\"></td></tr>");
	echo ("</table>");

// close out the form
	echo ("</form>");

?>

