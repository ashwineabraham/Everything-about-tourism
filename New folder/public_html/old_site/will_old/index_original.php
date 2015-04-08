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

        .big_button2 {
            -moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
            -webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
            box-shadow:inset 0px 1px 0px 0px #bbdaf7;
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #325C74), color-stop(1, #378de5) );
            background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#325C74', endColorstr='#378de5');
            background-color:#325C74;
            -webkit-border-top-left-radius:6px;
            -moz-border-radius-topleft:6px;
            border-top-left-radius:6px;
            -webkit-border-top-right-radius:6px;
            -moz-border-radius-topright:6px;
            border-top-right-radius:6px;
            -webkit-border-bottom-right-radius:6px;
            -moz-border-radius-bottomright:6px;
            border-bottom-right-radius:6px;
            -webkit-border-bottom-left-radius:6px;
            -moz-border-radius-bottomleft:6px;
            border-bottom-left-radius:6px;
            text-indent:0;
            border:1px solid #84bbf3;
            display:inline-block;
            color:#ffffff;
            font-family:Arial;
            font-size:12px;
            font-weight:bold;
            font-style:normal;
            height:30px;
            line-height:30px;
            width:100px;
            text-decoration:none;
            text-align:center;
            text-shadow:1px 1px 0px #528ecc;
        }
        
        .big_button {
-moz-border-radius: 6px;
-webkit-border-radius: 6px;
border-radius: 6px;
/*IE 7 AND 8 DO NOT SUPPORT BORDER RADIUS*/
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = '#ffffff', endColorstr = '#000000');
/*INNER ELEMENTS MUST NOT BREAK THIS ELEMENTS BOUNDARIES*/
/*Element must have a height (not auto)*/
/*All filters must be placed together*/
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr = '#ffffff', endColorstr = '#000000')";
/*Element must have a height (not auto)*/
/*All filters must be placed together*/
background-image: -moz-linear-gradient(top, #ffffff, #000000);
background-image: -ms-linear-gradient(top, #ffffff, #000000);
background-image: -o-linear-gradient(top, #ffffff, #000000);
background-image: -webkit-gradient(linear, center top, center bottom, from(#ffffff), to(#000000));
background-image: -webkit-linear-gradient(top, #ffffff, #000000);
background-image: linear-gradient(top, #ffffff, #000000);
-moz-background-clip: padding;
-webkit-background-clip: padding-box;
background-clip: padding-box;
/*Use "background-clip: padding-box" when using rounded corners to avoid the gradient bleeding through the corners*/
/*--IE9 WILL PLACE THE FILTER ON TOP OF THE ROUNDED CORNERS--*/

        }

        }
        .big_button:hover {
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
            background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
            background-color:#378de5;
        }
        
        .big_button:active {
            position:relative;
            top:1px;
        }
        
        .big_select {
            -moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
            -webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
            box-shadow:inset 0px 1px 0px 0px #bbdaf7;
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
            background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
            background-color:#79bbff;
            -webkit-border-top-left-radius:6px;
            -moz-border-radius-topleft:6px;
            border-top-left-radius:6px;
            -webkit-border-top-right-radius:6px;
            -moz-border-radius-topright:6px;
            border-top-right-radius:6px;
            -webkit-border-bottom-right-radius:6px;
            -moz-border-radius-bottomright:6px;
            border-bottom-right-radius:6px;
            -webkit-border-bottom-left-radius:6px;
            -moz-border-radius-bottomleft:6px;
            border-bottom-left-radius:6px;
            text-indent:0;
            border:1px solid #84bbf3;
            display:inline-block;
            color:#ffffff;
            font-family:Arial;
            font-size:12px;
            font-weight:bold;
            font-style:normal;
            height:30px;
            line-height:30px;
            width:100px;
            text-decoration:none;
            text-align:center;
            text-shadow:1px 1px 0px #528ecc;
        padding: 5px 5px 5px 5px;
        }
        
        .big_select:hover {
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
            background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
            background-color:#378de5;
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
        <td height="100%" class="stretch" valign="top"><center>
            
            <table cellpadding="10" cellspacing="0">
                <tr>
                    <td><img src="trans.gif" width="1" height="10"></td>
                </tr>
                <tr>
                    <td><select name="test" class="big_select"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td>
                    <td><select name="test" class="big_select"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td>
                    <td><select name="test" class="big_select"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td>
                    <td><a href="#" class="big_button">TEXT</a></td>
                </tr>
            </table>
    </center></tr>
</table>