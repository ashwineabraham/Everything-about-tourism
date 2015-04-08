<?php

// connect to the database
    include ("dbconnect.php");
	
// create our variables
	$country_code='';
	$country_name='';
	$region='';
	$category='';
	$startswith='';

// get the URL requested by the client
    $actual_link = $_SERVER["HTTP_HOST"];

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
    
// check the status of the cookie and create if necessary
    if (isset($_COOKIE["site"])){
        $site=$_COOKIE["site"];
    }else{
        $site=$site_key;
        setcookie("site",$site_key);
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
    
// uppercase the site key and colour
    $site_key=ucfirst($site_key);
    $site_colour=ucfirst($site_colour);

//echo $site_colour;
    switch ($site_colour){
        case "Red":
            $colour1='#d35543';
            $colour2='#822a25';
            break;
        case "Blue":
            $colour1='#1178b1';
            $colour2='#005186';
            break;
        case "Green":
            $colour1='#339900';
            $colour2='#267200';
        default:
            $colour1='#1178b1';
            $colour2='#005186';
            break;
    }

// concatenate the variables into a string
    $choose_wallpaper=$site_key."_".$site_colour."_".$choose_wallpaper.".jpg";

// convert case cos @#%$ server is case sensitive
    $site_colour=strtolower($site_colour);

// destroy some of the variables 
    unset ($query);
    unset ($result);
    unset ($row);
//    unset ($site_name);
    unset ($link_array);
    unset ($actual_link);

// set site headers to prevent caching
    header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
    header('Pragma: no-cache'); // HTTP 1.0.
    header('Expires: 0'); // Proxies.
?>

<head>

    <title><?php echo $site_title; ?></title>

    <style type="text/css">
        
        body{
            margin: 0;
            padding: 0
        }

        @font-face {
            font-family: 'titilliumregular';
            src: url('titillium-regular.eot');
            src: url('titillium-regular.eot?#iefix') format('embedded-opentype'),
                 url('titillium-regular.woff') format('woff'),
                 url('titillium-regular.ttf') format('truetype'),
                 url('titillium-regular.svg#titilliumregular') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        @font-face {
            font-family: 'titillium_bdbold';
            src: url('titillium-bold.eot');
            src: url('titillium-bold.eot?#iefix') format('embedded-opentype'),
                 url('titillium-bold.woff') format('woff'),
                 url('titillium-bold.ttf') format('truetype'),
                 url('titillium-bold.svg#titillium_bdbold') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        h1{
            font-family: Verdana;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
            text-shadow: 3px 3px 2px rgba(150, 150, 150, 0.7);
            font-size: 52px;
			
        }
		
		 h4{
            font-family: Verdana;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
            font-size: 18px;
			text-shadow: 5px 5px 3px rgba(0, 0, 0, 1);
			text-align:center;
        }
		
		select{
			width: 200px;
			border:1px solid #000000;
			 
			}
			
			input{
				border:1px solid #000000;
				
				}
        
		font.fh{
			 font-family: Verdana;
			 font-size: 14px;
			
			}
		
		font{
			 line-height: 200%;
			 padding-bottom: 20px;
			 
			
			}
			font.fc{
			 
			 text-align:center;
				
				}
			

		btn_txt{
			text-shadow: 5px 5px 3px rgba(0, 0, 0, 1);
			}
        * {
            font-family: verdana;
        }
        
        .stretch {
            background-image: url('http://www.<?php echo $site_name; ?>.com/images/<?php echo $choose_wallpaper; ?>');
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-color: <?php echo $colour1; ?>;
        }
        
        .btn {
            background: <?php echo $colour2; ?>;
            background-image: -webkit-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -o-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: linear-gradient(to bottom, <?php echo $colour1.",".$colour2; ?>);
            -webkit-border-radius: 4;
            -moz-border-radius: 4;
            border-radius: 7px;
            font-family: verdana;
            color: #ffffff;
            font-size: 14px;
            padding: 5px 10px 5px 10px;
            text-decoration: none;
        }
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/ajax-loader.gif) center no-repeat hsla(0,0%,0%,0.00);
}
    </style>

    <script type="text/javascript">
        function gen_mail_to_link(lhs,rhs,subject){
            document.write("<A HREF=\"mailto");
            document.write(":" + lhs + "@");
            document.write(rhs + "?subject=" + subject + "\" style=\"color:yellow\">" + lhs + "@" + rhs + "<\/A>");
        } 
		</script>
        
        <script>
		
		function validate()
{
	var con=document.forms["index"]["cboCountryCode"].value;  
	var region= document.forms["index"]["region"].value;
if (con.value=="none" && region.value=="none" ){
	alert ("Please Choose a Country");;
	return false;
}
	var con=document.forms["index"]["cboCountryCode"].value;
if (con.value=="none"){
	alert ("Please Choose a Country to Select a region");
	return false;
}
var region= document.forms["index"]["region"].value;
if (region.value=="none"){
	alert ("please Choose a region");
	return false;
}
return true;
}		
    </script> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>
</head>

<body>
<div class="se-pre-con"></div>

    <table cellpadding="0" cellspacing="0" width="100%" height="100%">

<!-- top row with H1 site title -->

        <tr>
            
                <td height="164" background="images/<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
                
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                    <tr>
                        <td valign="middle" ><a href="index.php" style="text-decoration:none;"> <h1 ><?php echo $site_title; ?></h1></a></td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                     <tr>
                        <td valign="middle"><h4><i>"World's <?php echo $site_key; ?> Search Engine"</i></h4></td>
                    </tr>
                </table></center>

            </td>
        </tr>

<!-- second row with NEW SITE option and drop-down menus -->

        <tr>
            <td height="100%" class="stretch" valign="top">
              <table height="100%" width="100%" border="0">
                    <tr>
                        <td width="100%" height="290" valign="top"><center>

<!-- add your site link -->

                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
                                </tr>
                                <tr>
                                    <td><img src="images/fade_left_<?php echo $site_colour; ?>.png"></td>
                                    <td background="images/fade_middle_<?php echo $site_colour; ?>.gif"> <a href="new_listing.php" style="text-decoration:none;"><font color="#ffffff">Add Your Website</font></a> </td>
                                    <td><img src="images/fade_right_<?php echo $site_colour; ?>.png"></td>
                                </tr>
                                <tr>
                                    <td height="21" colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
                                </tr>
                            </table>

<!-- COUNTRY combo box -->

                           <form name="index" action="list.php" method="POST" onSubmit="validate()" style='display:inline;'>

                              <select name="cboCountryCode" class="btn" >
                                    <option value="none"><btn_txt>Choose Country</btn_txt></option>

<?php

//get all active country codes and names
	$query="select country_name, country_code from countries where country_enabled='TRUE' order by country_name asc;";
	$result=mysql_query($query);

// create a row for each
	while ($row = mysql_fetch_array($result)) {
    	echo ("<option value=\"".$row["country_code"]."\"");

    	if ($country_code===$row["country_code"]){
    		echo (" selected");
    	}

    	echo (">".$row["country_name"]."</option>\n");

    }

?>

                                </select>
 
<!-- CATEGORY combo box -->

                              <select name="category" class="btn" >
                                    <option value="none">Choose Category</option>

<?php

// using the SITEKEY variable grab a list of all matching categories sorted alphabetically
	$query="select categdesc, categid from vCategory where sitekey like '".$site."' and categdesc <> '' order by categdesc asc;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		echo ("<option value=\"".$row["categid"]."\"");
	
		if ($category==$row["categid"]){
			echo (" selected");
		}
	
		echo (">".$row["categdesc"]."</option>\n");
	}

?> 


                              </select><img src="images/trans.gif" width="4" height="1"><input type="submit" value="Search" onClick="se-pre-con" class="btn" >
                                
                            </form></center>
                        </td>
                  </tr>
                    <tr>
                        <td height="100%"></td>
                    </tr>
                    <tr>
                        <td>

                           <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="10%"></td>
                                  <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%" background="images/<?php echo $site_colour; ?>_top_small.gif"><img src="trans.gif" height="82" width="1"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="4%"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%" background="images/<?php echo $site_colour; ?>_top_small.gif"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="4%"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%" background="images/<?php echo $site_colour; ?>_top_small.gif"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="4%"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%" background="images/<?php echo $site_colour; ?>_top_small.gif"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="4%"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%" background="images/<?php echo $site_colour; ?>_top_small.gif"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="4%"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%" background="images/<?php echo $site_colour; ?>_top_small.gif"></td>
                                    <td bgcolor="#000000" width="1"><img src="images/trans.gif" width="1" height="1"></td>
                                    <td width="10%"></td>
                                </tr>
                          </table>

                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" bgcolor="yellow"><img src="images/trans.gif" width="1" height="1"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><img src="images/trans.gif" width="1" height="10"></td>
                                </tr>
                                <tr>
                                    <td valign="top" align="left" width="200"><font class="fh" color="yellow" size="-1"><b><a href="contact_us.php" style="color:yellow">Contact Us</a></font></td>
                                    <td valign="top" align="center" width="100%"><center><font class="fh" color="yellow" size="-1"><b><a href="about_us.php" style="color:yellow">About Us</a></font></center></td>
                                    <td valign="top" align="right" width="200" ><font class="fh" color="yellow" size="-1"><b><a href="terms_and_conditions.php" style="color:yellow">Terms and Conditions</a><br></font></td>
                                </tr>
                                <tr>
                                    <td><img src="images/trans.gif" width="200" height="10"></td>
                                    <td></td>
                                    <td><img src="images/trans.gif" width="200" height="10"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><center>

<?php

    switch ($site){
        case "finance":
            echo ("<font  color=\"yellow\" size=\"-1\">A Member of the World Finance Search Engines' \"Top 20\" Global Finance Search Directories</font><br>");
            echo ("<font color=\"yellow\" size=\"-1\">The finance pages, finance listings, finance links and internet finance directories are prepared by www.worldfinancesearchengines.com under the Business Name<br>\"World Finance Search Engines\" as a finance industry service.</font><br>");
            echo ("<font color=\"yellow\" size=\"-1\">Please send updates and corrections to ");

            echo ("<SCRIPT LANGUAGE=\"JavaScript\" type=\"text/javascript\">");
            echo ("gen_mail_to_link('manager','worldfinancesearchengines.com','Feedback about your site...')");
            echo ("</SCRIPT>");
            echo ("<NOSCRIPT>");
            echo ("<em>Email address protected by JavaScript. Activate javascript to see the email.</em>");
            echo ("</NOSCRIPT>");

            echo (".</b></font><br>");
            echo ("<font color=\"yellow\" size=\"-1\">If you find any finance web pages, or finance link for any entry is not working, please also send us an email so we can contact the business and make the finance list totally reliable.</font>");
            break;
        default:
            echo ("<font color=\"yellow\" size=\"-1\">A Member of the World's Specialized Search Engines' Global, Very Specific Search Directories, and Precise Unambiguous Databases.<br>");
            echo ("<font color=\"yellow\" size=\"-1\">Now Searching on The Internet has Become Simple and Easy!<br>");
            echo ("<font color=\"yellow\" size=\"-1\">The various pages, listings, links and internet specialized directories are prepared by www.worldspecializedsearchengines.com under the<br>Business Name \"World Specialized Search Engines\" as a service to very particular and individual Industries Internationally.<br>");
            echo ("<font color=\"yellow\" size=\"-1\">Some specialized search engines may have only just commenced, therefore the number of listings may not be huge on your initial viewing - this<br>gives you an enormous benefit to List Your Business now, before your opposition, to reap all the benefits before them.<br>The Listing Price for Your Business is Only US$39 per annum.<br>");
            echo ("<font color=\"yellow\" size=\"-1\">Please send updates and corrections to ");

            echo ("<SCRIPT LANGUAGE=\"JavaScript\" type=\"text/javascript\">");
            echo ("gen_mail_to_link('manager','worldspecializedsearchengines.com','Feedback about your site...')");
            echo ("</SCRIPT>");
            echo ("<NOSCRIPT>");
            echo ("<em>Email address protected by JavaScript. Activate javascript to see the email.</em>");
            echo ("</NOSCRIPT>");

            echo (".<br>");
            echo ("<font color=\"yellow\" size=\"-1\">If you find any web pages, or link for any entry is not working, please also send us an email so we can contact the business and make the lists totally reliable.");
            break;
			
    }

?>
</br>
<font class="fc" color="yellow" size="-1" > (c) <?php echo $site_title; ?></font>

                                    </td>
            
                            </table>
                             
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
  
</body>