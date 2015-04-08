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
	<script language="javascript">

//on BLUR or loss of window focus close the popup window automatically
	    window.onblur=function(){self.close();};
	</script>
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

// sanitise the passed ID code just in case
	$provider_id=sanitize($_GET["provider_id"]);

// chck to see if the form has been submitted
	if ($_POST){

// sanitise the form inputs in case of suspect data
		$business_name=sanitize($_POST["business_name"]);
		$provider_id=sanitize($_POST["provider_id"]);
		$address=sanitize($_POST["address"]);
//		$city=sanitize($_POST["city"]);
//		$country=sanitize($_POST["country"]);
//		$state=sanitize($_POST["state"]);
//		$postcode=sanitize($_POST["postcode"]);
		$contact=sanitize($_POST["contact"]);
		$phone=sanitize($_POST["phone"]);
		$mobile=sanitize($_POST["mobile"]);
		$fax=sanitize($_POST["fax"]);
		$email=sanitize($_POST["email"]);
		$assoc_no=sanitize($_POST["assoc_no"]);
		$website=sanitize($_POST["website"]);
		$website_desc=sanitize($_POST["website_desc"]);

		mysql_query("update new_entries set 
		business_name='".$business_name."', 
		address='".$address."', 
		contact='".$contact."', 
		phone='".$phone."', 
		mobile='".$mobile."', 
		fax='".$fax."', 
		email='".$email."', 
		assoc_no='".$assoc_no."', 
		website='".$website."', 
		website_desc='".$website_desc."', 
		site_colour='".$_POST["site_colour"]."' 
		where id='".$provider_id."';");
		
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

// hidden input with side ID code for next step
	echo ("<input type=\"hidden\" name=\"provider_id\" value=\"".$provider_id."\">\n");

	echo ("<table>\n");
	echo ("<tr>\n");
	echo ("<td valign=\"top\" width=\"35%\">\n");
	echo ("<font face=\"arial\" size=\"-1\"><b>Instructions</b><p>You can edit some aspects of your providers here.<p>The site colour will default to blue unless you decide to change it.<p>Note that alterations will take effect immediateley and will be logged for later review.</b></font>\n");
	echo ("</td>\n");
 	echo ("<td><img src=\"images/trans.gif\" width=\"20\" height=\"1\"></td>\n");
	echo ("<td valign=\"top\"><table>\n");

// grab the sites details where the provider_id equals that chosen on the main screen
	$query="select * from new_entries where id='".$provider_id."';";

    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	echo ("<tr>\n<td>Provider Name</td>\n<td><input type=\"text\" name=\"business_name\" value=\"".$row["business_name"]."\"></td>\n</tr>\n");
    	echo ("<tr>\n<td>Address</td><td><input type=\"text\" name=\"address\" value=\"".$row["address"]."\"><td>\n</tr>\n");

// hidden under the assumption that not many businesses would move interstate
//    	echo ("<tr>\n<td>City</td><td><input type=\"text\" name=\"city\" value=\"".$row["city"]."\"><td>\n</tr>\n");
//    	echo ("<tr>\n<td>Country</td><td><input type=\"text\" name=\"country\" value=\"".$row["country"]."\"><td>\n</tr>\n");
//    	echo ("<tr>\n<td>State</td><td><input type=\"text\" name=\"state\" value=\"".$row["state"]."\"><td>\n</tr>\n");
//    	echo ("<tr>\n<td>Postcode</td><td><input type=\"text\" name=\"postcode\" value=\"".$row["postocde"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Contact</td><td><input type=\"text\" name=\"contact\" value=\"".$row["contact"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Phone</td><td><input type=\"text\" name=\"phone\" value=\"".$row["phone"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Mobile</td><td><input type=\"text\" name=\"mobile\" value=\"".$row["mobile"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Fax</td><td><input type=\"text\" name=\"fax\" value=\"".$row["fax"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>E-Mail</td><td><input type=\"text\" name=\"email\" value=\"".$row["email"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Assoc. No</td><td><input type=\"text\" name=\"assoc_no\" value=\"".$row["assoc_no"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Website</td><td><input type=\"text\" name=\"website\" value=\"".$row["website"]."\"><td>\n</tr>\n");
    	echo ("<tr>\n<td>Website Desc.</td><td><input type=\"text\" name=\"website_desc\" value=\"".$row["website_desc"]."\"><td>\n</tr>\n");

    	echo ("<tr><td>Site Domain Colour</td><td>\n");

		echo ("<select name=\"site_colour\">\n");
		echo ("<option>Choose a colour scheme</option>\n");
		echo ("<option value=\"black\"");

		if ($row["site_colour"]=="black"){
			echo(" SELECTED");
		}

		echo (">BLACK</option>\n");
		echo ("<option value=\"blue\"");
		
		if (($row["site_colour"]=="blue")or($row["site_colour"]==='')){
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
    }

    echo ("<tr>\n<td></td>\n<td align=\"left\"><input type=\"submit\" value=\"Update this Provider\"></td>\n</tr>\n");

    echo ("</table>\n");

    echo ("</form>");

?>

</body>