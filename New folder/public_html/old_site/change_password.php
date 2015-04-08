<head>
	<script type="text/javascript">
		window.onblur=function(){self.close();};
	</script>
</head>

<body>

<?php

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