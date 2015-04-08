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

// connect to the database
    include ("dbconnect.php");
    
// if the form has been submitted
    if ($_POST){

// create a salt for each passed variable
        $password_salt='Z0mb1eFir3';
        $loginname_salt='m@rv1nG0@t';
        
// sanitise our inputs to stop injection attacks or XSS
// yes yes I can hear you from here.. it's not the right way to do it..
// yes it's not using some third party plugin or PDO..
// well from my chair right now you are way off in the future and i'm here drunk so STFU
// the idea is to stop someone using "username' or 1=1" etc as an injection attack string
        $password=sanitize($_POST['password']);
        $loginname=sanitize($_POST['loginname']);
        
// concatenate our salts and sanitised variables with an underscore between
        $password=$password_salt."_".$password;
        $loginname=$loginname_salt."_".$loginname;
        
// hash each variable so even with the database we don't know either part of the username/password combo
        $password=md5($password);
        $loginname=md5($loginname);
                
// build the database query with the sanitised and hashed variables so no injection attack etc can be carried out
        $query="select count(*) as usercount from authorised_users where loginname='".$loginname."' and password='".$password."';";
    	$result=mysql_query($query);
    	while ($row = mysql_fetch_array($result)) {
	    
// if the username/password query returns anything other than a single result
            if ($row["usercount"]<>1){
		
// fail out with an error
                echo ("<meta http-equiv=\"refresh\" content=\"0;url=login.php?error=4\">");
		
// otherwise
            }else{
		
// get the UNIX timestamp
        		$time_now=time();

// create a unique hash for each user for each login with a hash to avoid same-second clashes
                $md5=$loginname_salt.$time_now;
                $md5=md5($md5);

// set a sanity check counter
                $md5_check=0;
				
// sanity check loop to make sure that md5 hasnt been generated before
                while ($md5_check<1){

// count how many times that md5 appears in the user_log table
                    $query="select count(*) as md5_count from user_log where md5='".$md5."';";
                    $result=mysql_query($query);
                    while ($row = mysql_fetch_array($result)) {

// sanity check - if the count is higher than zero then a rare but non-zero probability hash collision has occured
                        if ($row["md5_count"]>0){

// delay a second to increase the timestamp by one
                            sleep(1);

// get the timestamp again
                            $time_now=time();

// rehash
                            $md5=$loginname_salt.$time_now;

// regenerate the md5
                            $md5=md5($md5);

// otherwise
                        }else{

// there are zero matches so increment the counter to break the loop conditions above
                            $md5_check=1;
                        }
                    }
                }

// update the users record with the timestamp to reflect the last login time
        		mysql_query("update authorised_users set last_login = '".$time_now."' where loginname='".$loginname."' and password='".$password."';");

// update the log but we need to get the USER_ID first
        		$user_id=mysql_result(mysql_query("select id from authorised_users where loginname='".$loginname."' and password='".$password."';"),0);
        		mysql_query("insert into user_log set timestamp='".$time_now."', action='USER LOGIN', user_id='".$user_id."', md5='".$md5."';");
		
// set a cookie with the login MD5 or later reference
                setcookie("admin_md5",$md5);

// redirect to the admin page
                echo ("<meta http-equiv=\"refresh\" content=\"0;url=frameset1.php\">");
            }
        }        

// destroy our variables
        unset ($md5);
        unset ($user_id);
        unset ($md5_check);
        unset ($md5_count);
        unset ($query);
        unset ($time_now);
        unset ($row);
        unset ($loginname);
        unset ($password);
        unset ($loginname_salt);
        unset ($password_salt);
        unset ($output);
    } else {

?>

<head>

    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    
    <style>
        
        * {
            font-family: helvetica;
        }
        
        body{
            margin: 0;
            padding: 0;
            background-image: URL( images/world-map.gif);
            background-repeat: no-repeat;
            background-position: center;
            background-align: middle;
        }

    </style>

</head>

<body>

    <table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
        <tr>
            <td width="100%" height="100%" valign="middle">

                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td><center>

                            <form style="margin-bottom:0;margin-top:0" name="userlogin" action="login.php" method="POST">
                                <table>

<?php

    if (isset($_GET["error"])){
        echo ("<tr><td><img src=trans.gif width=1 height=20></td></tr>");
        echo ("<tr><td>");
        include ("red_start.inc");

        switch ($_GET["error"]){
            case 1:
                echo ("<font face=arial size=-1 color=#ffffff><center>Error!  Please log in again</center></font>");
                break;
            case 2:
                echo ("<font face=arial size=-1 color=#ffffff><center>Error!<br>Please log in again</center></font>");
                break;
            case 3:
                echo ("<font face=arial size=-1 color=#ffffff><center>Login Timeout!<br>Please log in again</center></font>");
                break;
            case 4:
                echo ("<font face=arial size=-1 color=#ffffff><center>Error!<br>Username or password wrong</center></font>");
                break;
        }

        include ("red_end.inc");
        echo ("</td></tr>");
    }

?>

                                    <tr><td><font face="arial" color="#2C6BA0"><center><b>Login here to continue</b></td></tr>
                                    <tr><td><center><input type="text" name="loginname" size="10"></td></tr>
                                    <tr><td><center><input name="password" type="password" size="10"></td></tr>
                                    <tr><td><center><INPUT TYPE="image" SRC="images/login1.gif" BORDER="0"></td></tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

<?php
    }
?>
    
    
    