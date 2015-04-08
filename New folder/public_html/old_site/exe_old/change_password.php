<head>
	<script type="text/javascript">
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
    
    if ($_POST["loginname"]){
// create a salt for each passed variable
        $password_salt='Z0mb1eFir3';
        $loginname_salt='m@rv1nG0@t';
        
// concatenate our salts and sanitised variables with an underscore between
        $password=$password_salt."_".$_POST["password"];
        $loginname=$loginname_salt."_".$_POST["loginname"];
        
// hash each variable so even with the database we don't know either part of the username/password combo
        $password=md5($password);
        $loginname=md5($loginname);
        
        mysql_query ("update authorised_users set loginname='".$loginname."', password='".$password."' where id='".$_POST["user_id"]."';");
        
    }
?>

<form action='change_password.php' method='post'>
    <table>
        <tr>
            <td>login</td>
            <td><input name='loginname' type='text'></td>
        </tr>
        <tr>
            <td>password</td>
            <td><input name='password' type='text'></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="hidden" name="user_id" value="<?php echo $_GET["user_id"]; ?>"><input type='submit'></td>
        </tr>
    </table>
</form>
    
</body>