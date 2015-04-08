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

// chck to see if the form has been submitted
	if ($_POST){

// sanitise the form inputs in case of suspect data
		$site_key=sanitize($_POST["site_key"]);
		$site_colour=sanitize($_POST["site_colour"]);
		$site_title=sanitize($_POST["site_title"]);
		$site_id=sanitize($_POST["site_id"]);

		mysql_query("update site_details set site_key='".$site_key."', site_colour='".$site_colour."', site_title='".$site_title."' where site_id='".$site_id."';");
		
		echo ("<script>");
		echo ("self.close();");
		echo ("window.onunload = refreshParent;");
		echo ("function refreshParent() {");
		echo ("window.opener.location.reload();");
		echo ("}");
		echo ("</script>");

	}

// sanitise the passed ID code just in case
	$site_id=sanitize($_GET["site_id"]);

// create the form
	echo ("<form name=\"update_site\" method=\"POST\" action=\"edit_single_site.php\">\n");

// hidden input with side ID code for next step
	echo ("<input type=\"hidden\" name=\"site_id\" value=\"".$_GET["site_id"]."\">\n");

	echo ("<table>\n");

// grab the sites details where the site_id equals that chosen on the main screen
	$query="select * from site_details where site_id='".$site_id."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

    	echo ("<tr>\n<td>Site Domain Name</td>\n<td>www.".$row["site_name"].".com</td>\n</tr>\n");
    	echo ("<tr>\n<td>Site Domain Category</td>\n<td>");

		echo ("<select name=\"site_key\"\>");
		echo ("<option>Choose a category</option>");

// pull all the unique SITEKEY strings to fill the drop-down menu 
		$query2="select distinct(sitekey) from vCategory order by sitekey asc;";
	    $result2=mysql_query($query2);
	    while ($row2 = mysql_fetch_array($result2)) {

	    	$lowercase=strtolower($row2["sitekey"]);

			echo ("<option value=\"".$lowercase."\"");
			
// if the string matches the sites stored colour then
			if ($row["site_key"]==$lowercase){

// make sure it's chosen as the default
				echo (" SELECTED");
			}

// convert it back to uppercase for the combo box text
			$row2["sitekey"]=strtoupper($row2["sitekey"]);

			echo (">".$row2["sitekey"]."</option>\n");
		}

    	echo ("</select></td></tr>");
    	echo ("<tr><td>Site Domain Colour</td><td>\n");

		echo ("<select name=\"site_colour\">\n");
		echo ("<option>Choose a colour scheme</option>\n");
		echo ("<option value=\"black\"");

		if ($row["site_colour"]=="black"){
			echo(" SELECTED");
		}

		echo (">BLACK</option>\n");
		echo ("<option value=\"blue\"");
		
		if ($row["site_colour"]=="blue"){
			echo(" SELECTED");
		}
		
		echo (">BLUE</option>\n");
		echo ("<option value=\"darkblue\"");
		
		if ($row["site_colour"]=="darkblue"){
			echo(" SELECTED");
		}
		
		echo (">DARK BLUE</option>\n");
		echo ("<option value=\"green\"");
		
		if ($row["site_colour"]=="green"){
			echo(" SELECTED");
		}
		
		echo (">GREEN</option>\n");
		echo ("<option value=\"red\"");
		
		if ($row["site_colour"]=="red"){
			echo(" SELECTED");
		}
		
		echo (">RED</option>\n");
		echo ("<option value=\"yellow\"");
		
		if ($row["site_colour"]=="yellow"){
			echo(" SELECTED");
		}
		
		echo (">YELLOW</option>\n");
		echo ("<option value=\"white\"");
		
		if ($row["site_colour"]=="white"){
			echo(" SELECTED");
		}
		
		echo (">WHITE</option>\n");
		echo ("</select>\n");
    	echo ("</td></tr>\n");

    	echo ("<tr><td>Site Title Text</td><td><input type=\"text\" name=\"site_title\" value=\"".$row["site_title"]."\"></td></tr>\n");

    }

    echo ("<tr>\n<td></td>\n<td align=\"left\"><input type=\"submit\" value=\"Update this Site\"></td>\n</tr>\n");

    echo ("</table>\n");

    echo ("</form>");

?>

</body>