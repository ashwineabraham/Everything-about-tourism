<head>
    <style>
        * {
            font-family: helvetica;
            font-size: 12px;
        }
    </style>
    <script>
    	function CenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
            var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
            var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);

            var misc_features;
            if (features) {
                misc_features = ', ' + features;
            }
            else {
                misc_features = ', status=no, location=no, scrollbars=yes, resizable=no';
            }
            var windowFeatures = 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + centerLeft + ',top=' + centerTop + misc_features;
            var win = window.open(url, wname, windowFeatures);
            win.focus();
            return win;
    	}
    </script>
</head>

<body>

    <a href="javascript:void(0)" onclick="CenterWindow(500,400,50,'add_new_user.php','Add a new user');"><img src="images/plus.png" border="0"></a> Add a new user<p>
    
    <table>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td width="150"></td>
            <td width="200" align="right">Last Recorded Login</td>
            <td width="200" align="right">Time since last login</td>
        </tr>
    
<?php

// connect to the database
    include ("dbconnect.php");
    
// get the current unix timestamp
    $time_now=time();
    
// get a list of all our users sorted by ID
    $query="select * from authorised_users order by id asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        
// convert the UNIX timestamp to a human readable format
        $login_date=date('d-m-Y H:i:s',$row["last_login"]);
        
// write out the user list with last login date
        echo ("<tr>");
        echo ("<td><a href=\"javascript:void(0)\" onclick=\"CenterWindow(500,400,50,'user_activity_log.php?user_id=".$row["id"]."','Activity Log');\"><img src=\"images/notebook--pencil.png\" border=\"0\" title=\"Edit this user\"></a></td>");
        echo ("<td><a href=\"javascript:void(0)\" onclick=\"CenterWindow(500,400,50,'change_password.php?user_id=".$row["id"]."','Activity Log');\"><img src=\"images/key--pencil.png\" border=\"0\" title=\"Change this users password\"></a></td>");
        echo ("<td><a href=\"javascript:void(0)\" onclick=\"CenterWindow(500,400,50,'user_activity_log.php?user_id=".$row["id"]."','Activity Log');\"><img src=\"images/clock-history.png\" border=\"0\" title=\"User History\"></a></td>");
        echo ("<td><b>".$row["firstname"]." ".$row["surname"]."</b></td>");
        echo ("<td align=\"right\">".$login_date."</td>");
        
// get the time since last login
        $datediff = $time_now - $row["last_login"];
        
// mathy stuff
        $hours_since_last_login=$datediff/(60*60);
        $hours_since_last_login=round($hours_since_last_login,2);
       
// more maths 
        if ($hours_since_last_login>24){
            $days_since_last_login=$hours_since_last_login/24;
            $hours_since_last_login=$hours_since_last_login-($days_since_last_login*24);
        }
        
        echo ("<td align=\"right\">".$hours_since_last_login." hours</td>");
        echo ("</tr>");
    }
    
?>

</body>