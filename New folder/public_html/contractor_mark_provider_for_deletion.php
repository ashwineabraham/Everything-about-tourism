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
		$deletion_request=sanitize($_POST["deletion_request"]);
		$deletion_request_reason=sanitize($_POST["deletion_request_reason"]);
		$provider_id=sanitize($_POST["provider_id"]);

		$time_now=time();

// make the changes to the provider record
		mysql_query ("update provider set deletion_request='".$deletion_request."', deletion_request_reason='".$deletion_request_reason."', deletion_request_timestamp='".$time_now."' where providerid='".$provider_id."';");

// update the user log
	    mysql_query ("insert into user_log set user_id='".$user_id."', action='PROVIDER ".$provider_id." DELETION REQUEST', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
	
		echo ("<script>");
		echo ("self.close();");
		echo ("window.onunload = refreshParent;");
		echo ("function refreshParent() {");
		echo ("window.opener.location.reload();");
		echo ("}");
		echo ("</script>");
	}

	$query="select providername from provider where providerid='".$provider_id."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	echo ("Deletion request for <b>".$row["providername"]."</b><p>");
    }

	echo ("<form name=\"mark_for_deletion\" action=\"contractor_mark_provider_for_deletion.php\" method=\"POST\">");

	echo ("<input type=\"hidden\" name=\"provider_id\" value=\"".$provider_id."\">");

	echo ("<table>");
	echo ("<tr>");
	echo ("<td valign=\"top\">Delete this provider?</td><td><input type=\"radio\" name=\"deletion_request\" value=\"no\" checked> No<br><input type=\"radio\" name=\"deletion_request\" value=\"yes\"> Yes<br></td>");
	echo ("</tr><tr>");
	echo ("<td valign=\"top\">Reason</td><td><textarea name=\"deletion_request_reason\" cols=\"45\" rows=\"5\">Why is this provider being deleted?</textarea></td>");
	echo ("</tr>");
	echo ("<tr><td></td><td><input type=\"submit\" value=\"Submit deletion request\"></td></tr>");
	echo ("</table>");

?>

