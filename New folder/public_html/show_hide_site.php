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
    
// sanitise our inputs
    $show_hide=sanitize($_GET["show_hide"]);
    $site_id=sanitize($_GET["site_id"]);
    
// check our sites visibility
    if ($show_hide=="show"){

//  if it's hidden then the icon clicked would be a cross to turn off invisibility mode so we can change the hidden from YES to NO
        $query="update site_details set site_hidden='no' where site_id='".$site_id."';";
    }else{

// and vice versa for the visible to invisible
        $query="update site_details set site_hidden='yes' where site_id='".$site_id."';";        
    }
    
// run the query
    mysql_query ($query);
    
// get the current time
    $time_now=time();

// grab the user id for this md5
	$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// update the user log with this action
	    mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='DOMAIN ".$site_id." VISIBILITY TOGGLED', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
	}

// destroy our variables
    unset ($site_id);
    unset ($show_hide);
    unset ($output);
    unset ($input);
    
?>

<script language="javascript">
    window.opener.location.reload();
    self.close();
</script>