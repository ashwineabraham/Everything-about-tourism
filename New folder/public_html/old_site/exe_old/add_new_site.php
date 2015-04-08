<head>
    <style type="text/css">
		* {
		    font-family: helvetica;
		}
    </style>
</head>

<body>

<?php

// if the form has been filled out of not
	if (!$_POST){

// if it had then check to see if an error code has been passed
		if ($_GET){

// if so write out the error message
			echo ("<font color=\"red\">Error! This site already exists</font><p>");
		}

?>

	<form name="new domain" method="POST" action="add_new_site.php">

		<table>
			<tr>
				<td>Site Key</td>
				<td width="300" align="right">
				    <select name="site_key">
				    	<option>Choose a site key</option>
						<option value="4x4">4x4</option>
						<option value="adventure">Adventure</option>
						<option value="advertising">Advertising</option>
						<option value="astrology">Astrology</option>
						<option value="collectables">Collectables</option>
						<option value="disability">Disability</option>
						<option value="education">Education</option>
						<option value="finance">Finance</option>
						<option value="health">Health</option>
						<option value="hunting">Hunting</option>
						<option value="relationships">Relationships</option>
						<option value="sunglasses">Sunglasses</option>
						<option value="tourism">Tourism</option>
						<option value="weddings">Weddings</option>
				    </select>
				</td>
			</tr>
			<tr>
				<td>Site Domain Name</td>
				<td width="300" align="right">www.<input type="text" name="site_name">.com</td>
			</tr>
			<tr>
				<td>Site Title</td>
				<td width="300" align="right"><input type="text" name="site_title"></td>
			</tr>
			<tr>
				<td>Site colour scheme</td>
				<td width="300" align="right">
					<select name="site_colour">
						<option value="black">Black</option>
						<option value="blue">Blue</option>
						<option value="darkblue">Dark Blue</option>
						<option value="green">Green</option>
						<option value="red">Red</option>
						<option value="yellow">Yellow</option>
						<option value="white">White</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit"></td>
			</tr>
		</table>

	</form>

<?php
	
	} else {

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

// set error level to zero
		$error=0;

// make sure our inputs are clean
		$site_key=sanitize($_POST["site_key"]);
		$site_colour=sanitize($_POST["site_colour"]);
		$site_name=sanitize($_POST["site_name"]);
		$site_title=sanitize($_POST["site_title"]);

// get the UNIX timestamp
		$time_now=time();

// sanity check to make sure we dont enter the same domain twice
		$query=("select count(*) as sanity_check from site_details where site_name='".$site_name."';");
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {

// if the count of the domain names is greater than zero the site already exists so error out
	    	if ($row["sanity_check"]>0){
	    		echo ("This site already exists");

// note the error
	    		$error=1;
	    	} else {

// otherwise insert the new domain into the list
				mysql_query ("insert into site_details set site_key='".$site_key."', site_colour='".$site_colour."', site_title='".$site_title."', site_name='".$site_name."', site_created='".$time_now."', site_hidden='no', site_deleted='no';");

// grab the user id for this md5
				$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
			    $result=mysql_query($query);
			    while ($row = mysql_fetch_array($result)) {

// update the user log with this action
				    mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='DOMAIN ".$site_name." ADDED', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
				}
	    	}
	    }

// destroy our variables
	    unset ($search);
	    unset ($output);
	    unset ($input);
	    unset ($site_name);
	    unset ($site_title);
	    unset ($site_colour);
	    unset ($site_details);
	    unset ($site_key);
	    unset ($query);
	    unset ($row);
	    unset ($result);

// if an error has not been passed
		if ($error<1){

// refresh the parent page and close out
			echo ("<script>");
			echo ("self.close();");
			echo ("window.onunload = refreshParent;");
			echo ("function refreshParent() {");
			echo ("window.opener.location.reload();");
			echo ("}");
			echo ("</script>");

// otherwise
		} else{

// refresh the page and show the error
			echo ("<META http-equiv=\"refresh\" content=\"0;add_new_site.php?error=1\">"); 
		}
	}    
    
?>

</body>