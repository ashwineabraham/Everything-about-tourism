<head>
    <style type="text/css">
		* {
		    font-family: helvetica;
		}
    </style>
</head>

<body>

	<table>
		<tr>
			<td valign="top" width="200">Reports<p>
				<a href="domain_report.php?report_type=this_week">New sites this week</a><br>
				<a href="domain_report.php?report_type=this_month">New sites this month</a>
			</td>
			<td valign="top">

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

// in case some muppet tries to add in SQL code it truncates the submitted string at the first equals
	    $output = preg_replace('/\;.*/', '', $output);
	    $output = preg_replace('/=.*/', '', $output);

		return $output;
    }

// connect to the database
	include ("dbconnect.php");

// get the current time
	$time_now=time();

// some generic time calculations
	$this_week=strtotime("-1 week");
	$this_month=strtotime("-1 month");

// clean out inputs
	$report_type=sanitize($_GET["report_type"]);

// determine the report type by choosing the appropriate query
	switch ($report_type) {
		case "this_week":
			$query="select * from site_details where site_created > '".$this_week."';";
			break;
		case "this_month":
			$query="select * from site_details where site_created > '".$this_month."';";
			break;
		default:
			$query="select * from site_details where site_created > '".$this_week."';";
			break;
		}

// start a table to display the results
	echo ("<table cellspacing=\"0\" cellpadding=\"3\">");
	echo ("<tr>");
	echo ("<td width=\"350\"><b>Domain</b></td>");
	echo ("<td><b>Date added</b></td>");
	echo ("<td><b>Added by</b></td>");
	echo ("</tr>");

// set the row counter variable
	$rowcounter=0;

// execute the query
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {


    	$created=date('d-m-Y H:i', $row["site_created"]);

		if ($rowcounter%2==0){
			$bgcolor="#fef7fa";
		}else{
			$bgcolor="#edf6f9";
		}

    	echo ("<tr>");
    	echo ("<td bgcolor=\"".$bgcolor."\"><font color=\"#b5b5b5\">www.</font>".$row["site_name"]."<font color=\"#b5b5b5\">.com</font></td>");
    	echo ("<td bgcolor=\"".$bgcolor."\">".$created."</td>");
    	echo ("<td bgcolor=\"".$bgcolor."\">".$added_by."</td>");
    	echo ("</tr>");

    	$rowcounter++;

    }

    echo ("</table>");

// grab the user id for this md5
	$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// update the user log with this action
	    mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='DOMAIN REPORT ".$report_type." VIEWED', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
	}

?>

			</td>
		</tr>
	</table>

</body>