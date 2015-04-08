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

// if the form has been submitted..
	if ($_POST){

// sanitize our data just in case..
	    $site_name=sanitize($_POST["site_name"]);
	    $site_title=sanitize($_POST["site_title"]);
	    $site_key=sanitize($_POST["site_key"]);
	    $site_colour=sanitize($_POST["site_colour"]);

// quick sanity check to see if the site is already in the database
	    $query="select count(*) as sanity_check from site_details where site_name='".$site_name."';";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
		
// match the entered name against the current records and if there are any matches..
		if ($row["sanity_check"]>0){
		    
// show an error
		    echo ("This site is already in the database.");
		    
// otherwise..
		}else{
		    
// update the database
		    mysql_query("insert into site_details set site_name='".$site_name."', site_title='".$site_title."', site_key='".$site_key."', site_colour='".$site_colour."';");				
		}
	    }
	}

?>

<form name="site_edit" method="POST" action="edit_sites.php">
	<table>
		<tr>
			<td>Domain name</td>
			<td><input type="text" name="site_name"></td>
		</tr>
		<tr>
			<td>Site Title</td>
<!--			<td><input type="text" name="site_title"></td> -->
			<td>
			    <select name="site_title">

<?php

	$query="select site_name from site_details order by site_name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	echo ("<option value=\"".$row["site_name"]."\">".$row["site_name"]."</option>\n");
    }

?>

			    </select>
			</td>
		</tr>
		<tr>
			<td>Site key</td>
			<td>
			    <select name="site_key">
					<option value="4x4">4x4</option>
					<option value="adventure">ADVENTURE</option>
					<option value="advertising">ADVERTISING</option>
					<option value="astrology">ASTROLOGY</option>
					<option value="collectables">COLLECTABLES</option>
					<option value="disability">DISABILITY</option>
					<option value="education">EDUCATION</option>
					<option value="finance">FINANCE</option>
					<option value="health">HEALTH</option>
					<option value="hunting">HUNTING</option>
					<option value="relationships">RELATIONSHIPS</option>
					<option value="sunglasses">SUNGLASSES</option>
					<option value="tourism">TOURISM</option>
					<option value="weddings">WEDDINGS</option>
			    </select>
			</td>
		</tr>
		<tr>
			<td>Colour scheme</td>
			<td>
			    <select name="site_colour">
					<option value="black">BLACK</option>
					<option value="blue">BLUE</option>
					<option value="darkblue">DARK BLUE</option>
					<option value="green">GREEN</option>
					<option value="red">RED</option>
					<option value="yellow">YELLOW</option>
					<option value="white">WHITE</option>
			    </select>	
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit"></td>
		</tr>
	</table>
</form>

</body>