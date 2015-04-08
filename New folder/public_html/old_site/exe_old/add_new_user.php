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

	include ("dbconnect.php");

	if ($_POST){

// create a salt for each passed variable
        $password_salt='Z0mb1eFir3';
        $loginname_salt='m@rv1nG0@t';
        
// sanitise our inputs to stop injection attacks
        $password1=sanitize($_POST['password1']);
        $password2=sanitize($_POST['password2']);
        $firstname=sanitize($_POST['firstname']);
        $surname=sanitize($_POST['surname']);
        $loginname=sanitize($_POST['loginname']);
        
// concatenate our salts and sanitised variables with an underscore between
        $password1=$password_salt."_".$password1;
        $password2=$password_salt."_".$password2;
        $loginname=$loginname_salt."_".$loginname;

// hash each variable so even with the database we don't know either part of the username/password combo
        $password1=md5($password1);
        $password2=md5($password2);
        $loginname=md5($loginname);

// quick sanity check in case of a typo in the password fields
        if ($password1===$password2){

// create our new user
        	mysql_query ("insert into authorised_users set firstname='".$firstname."', surname='".$surname."', loginname='".$loginname."', password='".$password1."', country_represented='".$_POST["country_represented"]."';");

// otherwise
        } else {
 
// error out
        	echo ("Passwords not entered correctly!");
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

	<form name="create_new_user" action="add_new_user.php" method="POST">

		<table>
			<tr>
				<td>Firstname</td>
				<td><input name="firstname" type="text"></td>
			</tr>
			<tr>
				<td>Surname</td>
				<td><input name="surname" type="text"></td>
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

// create a string with the returned list of currently assigned regions
    	$string=$string.",'".$row["country_represented"]."'";

    }

// remove the starting comma
    $string=substr($string, 1);

// start a drop bown box
    echo ("<select name=\"country_represented\">");

// get a filtered list of all countries excluding all those already assigned
    $query="select * from countries where country_enabled='TRUE' and country_code not in (".$string.") order by country_name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// create an option for each
    	echo ("<option value=\"".$row["country_code"]."\">".$row["country_name"]." (".$row["country_code"].")</option>\n");

    }

// finish the drop down list
    echo ("</select>");

?>			
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit"></td>
			</tr>
		</table>

	</form>

</body>

<?php
	
	}

?>