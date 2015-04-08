<?php

    header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
    header('Pragma: no-cache'); // HTTP 1.0.
    header('Expires: 0'); // Proxies.

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
        $site_key=$row["site_key"];
        $site_colour=$row["site_colour"];
        $site_title=$row["site_title"];
    }

// pick a random number
    $choose_wallpaper=rand(1,5);
    
// uppercase the site kay and colour
    $site_key=ucfirst($site_key);
    $site_colour=ucfirst($site_colour);
    
// concatenate the variables into a string
    $choose_wallpaper=$site_key."_".$site_colour."_".$choose_wallpaper.".jpg";

// destroy some of the variables 
    unset ($query);
    unset ($result);
    unset ($row);
    unset ($site_name);
    unset ($link_array);
    unset ($actual_link);
?>

<head>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0
        }
        @font-face {
            font-family: Delicious;
            src: url('Titillium-Regular.otf');
        }
        @font-face {
            font-family: Delicious;
            font-weight: bold;
            src: url('Titillium-Bold.otf');
        }
        h1{
            font-family: Titillium, sans-serif;
            color: yellow;
            margin: 0;
            padding: 15;
        }
        .stretch {
            background-image: url('<?php echo $choose_wallpaper; ?>');
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        
        * {
        font-family: helvetica;
        }
        
        .btn {
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 5;
            -moz-border-radius: 5;
            border-radius: 5px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

        .btn:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
        }

/* This button was generated using CSSButtonGenerator.com*/
        
    </style>
</head>

<table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td height="200" background="<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#ffffff"><img src="trans.gif" width="2" height="2"></td>
                </tr>
                <tr>
                    <td valign="middle"><h1><?php echo $site_title; ?></h1></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff"><img src="trans.gif" width="2" height="2"></td>
                </tr>
            </table></center>
        </td>
    </tr>
    <tr>
        <td height="100%" class="stretch" valign="middle"><center><a href="#" class="btn">TEXT</a><p><select name="test" class="btn"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></center></td>
    </tr>
</table>