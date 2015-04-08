<?php

	include ("dbconnect.php");

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
    	} else {
    	    if (get_magic_quotes_gpc()) {

// strip out back slashes
        		$input = stripslashes($input);
    	    }

// pass the string to the CLEANINPUT function for further processing
    	    $input  = cleanInput($input);

// escapes special characters contained in the string such as ' or \
    	    $output = mysql_real_escape_string($input);
    	}

// in case of some muppet trying to add in SQL code it truncates the submitted string at the first equal sign
    	$output = preg_replace('/\=.*/', '', $output);

    	return $output;
    }

	if ($_POST){

// clean out inputs
        $firstname=sanitize($_POST['firstname']);
        $lastname=sanitize($_POST['lastname']);
        $loginname=sanitize($_POST['loginname']);
        $password1=sanitize($_POST['password1']);
        $password2=sanitize($_POST['password2']);
        $security_level=sanitize($_POST['security_level']);

// create a salt for each passed variable
        $password_salt='Z0mb1eFir3';
        $loginname_salt='m@rv1nG0@t';
        
// concatenate our salts and sanitised variables with an underscore between
        $password1=$password_salt."_".$password1;
        $password2=$password_salt."_".$password2;
        $loginname=$loginname_salt."_".$_POST["loginname"];
        
// hash each variable so even with the database we don't know either part of the username/password combo
        $password1=md5($password1);
        $password2=md5($password2);
        $loginname=md5($loginname);

// if the passwords dont match error out and get them to reenter
        if ($password1<>$password2){
            echo ("<meta http-equiv=\"refresh\" content=\"0;url=add_new_user.php?error=1\">");
        }else{
	        mysql_query ("insert into authorised_users set firstname='".$firstname."', surname='".$lastname."', loginname='".$loginname."', password='".$password."', security_level='".$security_level."';");
        }
        

	} else { 

?>

<head>
    <style>
        * {
            font-family: helvetica;
            font-size: 12;
        }
    </style>
</head>

<body>

<?php

    if (isset($_GET["error"])){
        echo ("<table><tr><td><img src=trans.gif width=1 height=20></td></tr>");
        echo ("<tr><td>");
        include ("red_start.inc");
        echo ("<font face=arial size=-1 color=#ffffff><center>Error!<br>The entered passwords do not match</center></font>");
        include ("red_end.inc");
        echo ("</td></tr></table>");
    }

?>

	<form name="create_new_user" action="add_new_user.php" method="POST">

		<table>
			<tr>
				<td>Firstname</td>
				<td><input name="firstname" type="text"></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><input name="lastname" type="text"></td>
			</tr>
			<tr>
				<td>Login Name</td>
				<td><input name="loginname" type="text"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="password1" type="password"></td>
			</tr>
			<tr>
				<td>Password again</td>
				<td><input name="password2" type="password"></td>
			</tr>
			<tr>
				<td>Country Represented</td>
				<td>

<?php

// create a blank string
	$string='';

// get a list of currently assigned countries
	$query="select distinct(country_represented) as country_represented from authorised_users;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// create a string with the 
    	$string=$string.",'".$row["country_represented"]."'";

    }

    $string=substr($string, 1);

    echo ("<select name=\"country_represented\">");

//    $query="select * from countries where country_enabled='TRUE' and country_code not in (".$string.") order by country_name asc;";
    $query="select * from countries where country_enabled='TRUE' order by country_name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

    	echo ("<option value=\"".$row["country_code"]."\">".$row["country_name"]."</option>\n");

    }

    echo ("</select>");

?>			

				</td>
			</tr>
			<tr>
				<td>Security Level</td>
				<td align="left"><select name="security_level"><option value="1">1 (lowest)</option><option value="2">2</option><option value="3">3 (admin)</option></select>
			<tr>
				<td colspan="2" align="right"><input type="submit"></td>
			</tr>
		</table>

	</form>

</body>

<?php
	
	}

?>