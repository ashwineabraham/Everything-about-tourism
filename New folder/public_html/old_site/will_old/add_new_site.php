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
</head>

<body>

<?php

	if (!$_POST){

?>

	<form name="new domain" method="POST" action="add_new_site.php">

		<table>
			<tr>
				<td>Site Key</td>
				<td>
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
				<td><input type="text" name="site_name"></td>
			</tr>
			<tr>
				<td>Site Title</td>
				<td><input type="text" name="site_title"></td>
			</tr>
			<tr>
				<td>Site colour scheme</td>
				<td>
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

		$site_key=sanitize($_POST["site_key"]);
		$site_colour=sanitize($_POST["site_colour"]);
		$site_colour=sanitize($_POST["site_name"]);
		$site_title=sanitize($_POST["site_title"]);

		$query=("select count(*) as sanity_check from site_details where site_name='".$site_name."';");
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {

	    	if ($row["sanity_check"]>0){
	    		echo ("This site already exists");
	    	} else {

				echo ("insert into site_details set site_key='".$site_key."', site_colour='".$site_colour."', site_title='".$site_title."', site_name='".$site_name."';");

	    	}
	    }
				
		// echo ("<script>");
		// echo ("self.close();");
		// echo ("window.onunload = refreshParent;");
		// echo ("function refreshParent() {");
		// echo ("window.opener.location.reload();");
		// echo ("}");
		// echo ("</script>");

	}    
    
?>