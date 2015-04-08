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

// in case of some muppet trying to add in SQL code it truncates the submitted string at the first semi-colon
		$output = preg_replace('/\;.*/', '', $output);

		return $output;
	}

	include ("dbconnect.php");

// lets clean our inputs.. yes it's not PDO but it's fit enough for purpose
	$site_category=sanitize($_POST['site_category']);
	$business_name=sanitize($_POST['business_name']);
	$address=sanitize($_POST['address']);
	$city=sanitize($_POST['city']);
	$country=sanitize($_POST['country']);
	$state=sanitize($_POST['state']);
	$postcode=sanitize($_POST['postcode']);
	$contact=sanitize($_POST['contact']);
	$phone=sanitize($_POST['phone']);
	$mobile=sanitize($_POST['mobile']);
	$fax=sanitize($_POST['fax']);
	$email=sanitize($_POST['email']);
	$assoc_no=sanitize($_POST['assoc_no']);
	$website=sanitize($_POST['website']);
	$website_desc=sanitize($_POST['website_desc']);
	$category1=sanitize($_POST['category1']);
	$category2=sanitize($_POST['category2']);
	$category3=sanitize($_POST['category3']);
	$category4=sanitize($_POST['category4']);
	$category5=sanitize($_POST['category5']);

// get the current time
	$time_submitted=time();

// create the query string
	$query="insert into new_entries set
		site_category='".$site_category."',
		business_name='".$business_name."',
		address='".$address."',
		city='".$city."',
		country='".$country."',
		state='".$state."',
		postcode='".$postcode."',
		contact='".$contact."',
		phone='".$phone."',
		mobile='".$mobile."',
		fax='".$fax."',
		email='".$email."',
		assoc_no='".$assoc_no."',
		website='".$website."',
		website_desc='".$website_desc."',
		category1='".$category1."',
		category2='".$category2."',
		category3='".$category3."',
		category4='".$category4."',
		category5='".$category5."',
		time_submitted='".$time_submitted."',";

// if the add request came from a contractor then
		if (isset($_POST["contractor_id"])){

// insert the contractor ID to the request
			$query=$query."contractor_id='".$_POST["contractor_id"]."',";
		}
		
// complete the query string
		$query=$query."approved='no';";

// enter the submitted data into a temporary table
	mysql_query($query);

// destroy our variables
	unset ($query);
	unset ($search);
	unset ($input);
	unset ($output);
	unset ($time_submitted);
	unset ($business_name);
	unset ($address);
	unset ($city);
	unset ($country);
	unset ($state);
	unset ($postcode);
	unset ($contact);
	unset ($phone);
	unset ($mobile);
	unset ($fax);
	unset ($email);
	unset ($assoc_no);
	unset ($website);
	unset ($website_desc);
	unset ($category1);
	unset ($category2);
	unset ($category3);
	unset ($category4);
	unset ($category5);

// if the add request came from a contracter then
	if (isset($_POST["contractor_id"])){

// return to the contractor page
        echo ("<meta http-equiv=\"refresh\" content=\"0;url=contractor_add_new_listing.php?submitted=yes\">");

// otherwise refresh the parent page and close out
	}else{
		echo ("<script>");
		echo ("self.close();");
		echo ("window.onunload = refreshParent;");
		echo ("function refreshParent() {");
		echo ("window.opener.location.reload();");
		echo ("}");
		echo ("</script>");
	}
	
	
	
?>