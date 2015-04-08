<?php

// connect to the database
    include ("dbconnect.php");

// get the URL requested by the client
    $actual_link = $_SERVER[HTTP_HOST];

// deconstruct the URL using the "." as a delimter
    $link_array=explode('.',$actual_link);

// if the first array value is "www"..
    if ($link_array[0]==='www'){

// then use the second array value to test with
        $site_name=$link_array[1];
    }else{

// otherwise the www is missing and the first array value holds the site name
        $site_name=$link_array[0];
    }

// grab the site details from the SITE_DETAILS table based on the URL
    $query="select * from site_details where site_name='".$site_name."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        
// set a bunch of variables we'll use to define the colour, title, and base SITEKEY
        setcookie("site",$row["site_key"]);
        $site_title=$row["site_title"];
    }

// some time variables
	$timenow=time();
	$an_hour_ago=$timenow-3600;

// check to see if a cookie value for ADMIN_MD5 has been set
	if (!isset($_COOKIE["admin_md5"])){

// if not then error out to the login page
        echo ("<meta http-equiv=\"refresh\" content=\"0;url=login.php?error=1\">");

// otherwise
	} else {

// check if a cookie record exists in the database
		$query="select count(*) as MD5_count from user_log where md5='".$_COOKIE["admin_md5"]."';";
        $result=mysql_query($query);
        while ($row = mysql_fetch_array($result)) {

// if the count is anything other than exactly one then...
        	if ($row["MD5_count"]<>1){

// error out to the login page
		        echo ("<meta http-equiv=\"refresh\" content=\"0;url=login.php?error=2\">");       		
        	}
        }

// get the login timestamp and user ID from the user_log table
		$query="select timestamp, user_id from user_log where md5='".$_COOKIE["admin_md5"]."';";
        $result=mysql_query($query);
        while ($row = mysql_fetch_array($result)) {

// if the login is older than an hour
        	if ($row["timestamp"]<$an_hour_ago){

// error out to the login page
		        echo ("<meta http-equiv=\"refresh\" content=\"0;url=login.php?error=3\">");
        	} else {

// get the users security level
	        	$query1="select security_level from authorised_users where id='".$row["user_id"]."';";
		        $result1=mysql_query($query1);
		        while ($row1 = mysql_fetch_array($result1)) {
		        	$security_level=$row1["security_level"];
		        }

// if all conditions are met then show the admin page
?>

<head>
	<title><?php echo $site_name; ?></title>
</head>

<frameset>
    <frameset rows="164,*" frameborder="0" framespacing="0" border="0">
        <frame name="TITLE" src="title_frame.php" frameborder="0">
        <frameset cols="40,*,40" frameborder="0" framespacing="0" border="0">
	        <frame src="col.php">
	        <frameset rows="31,*" frameborder="0" framespacing="0" border="0">

<?php
// show the menu commiserate with the users security level
				switch ($security_level) {
					case 1:
						echo ("<frame name=\"MENU\" src=\"level1_menu.php\" frameborder=\"0\">");
						break;
					case 2:
						echo ("<frame name=\"MENU\" src=\"level2_menu.php\" frameborder=\"0\">");
						break;
					case 3:
						echo ("<frame name=\"MENU\" src=\"level3_menu.php\" frameborder=\"0\">");
						break;
				}

?>

		        <frame name="ADMIN" src="admin.php" frameborder="0">
		    </frameset>
	        <frame src="col.php">
		</frameset>
    </frameset>
<frameset>  

<?php
        	}
        }
	}

// destroy our variables
	unset ($query);
	unset ($result);
	unset ($row);
	unset ($query1);
	unset ($result1);
	unset ($row1);
	unset ($timenow);
	unset ($an_hour_ago);
	unset ($security_level);

?>
