<head>
    <style type="text/css">
	body{
	    margin: 0;
	    padding: 0
	}
	* {
	    font-family: helvetica;
	}
    </style>
	<script language="javascript">

//on BLUR or loss of window focus close the popup window automatically to prevent "lost" popups from building up behind the main window
	    window.onblur=function(){self.close();};
	</script>
</head>

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
    
// sanitise our input just in case
    if ($_GET){
	    $provider_id=sanitize($_GET["provider_id"]);
    }else{
	    $provider_id=sanitize($_POST["provider_id"]);
    }
		
// get the current time
    $time_now=time();

// detect of the form has been submitted
    if ($_POST){
	
// only a single field is passed aside from the provider id code
        $reason=sanitize($_POST["reason"]);
		
// update the chosen new provider record
		mysql_query("update new_entries set site_deleted='pending', site_deleted_reason='".$reason."', site_deleted_time='".$time_now."' where id='".$provider_id."';");

// grab the user id for this md5
		$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {

// update the user log with this action
		    mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='PROVIDER ".$provider_id." MARKED FOR DELETION', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
		}

// destroy our variables
		unset ($site_id);
		unset ($show_hide);
		unset ($output);
		unset ($reason);
		unset ($input);
	    
		echo ("<script language=\"javascript\">");
		echo ("window.opener.location.reload();");
		echo ("window.close();");
		echo ("</script>");

    } else {
	
?>

<body>
    
    <form name="contractor_delete_provider" action="contractor_delete_provider.php" method="POST">
	
	<input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">

	<table>
	    <tr>
			<td valign="top"><font face="arial" size="-1"><b>Reason for deletion</b></font></td>
		</tr>
		<tr>
			<td><textarea name="reason"></textarea></td>
	    </tr>
	    <tr>
			<td align="right"><input type="submit" value="Submit deletion request"></td>
	    </tr>
	</table>
    </form>
	
</body>

<?php	
	
    }
    
?>