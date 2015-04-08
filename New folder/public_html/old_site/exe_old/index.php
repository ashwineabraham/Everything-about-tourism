<?php

    $finance_sitename_array=array('worldfinancesearchengines','worldfinancesearchengine','thefinancetoolkit','10outof10financiers','1stclassfinanciers','5starfinanciers','all-about-finance','a-zoffinance','bestfinancebusinesses','everything-about-finance','everythingforfinance','financebestbuys','financeencyclopedias','financealist','financewhoswho','thefinancehelpdesk','thefinancesearchengine','thefinancespecialist','top100infinance','worldsfinancedirectory','worldsfinanciers');
    $disability_sitename_array=array('a-zofdisability','allaboutdisability','disabilitysearchengine','everythingaboutdisability','everythingfordisability','thedisabilityspecialists','top100indisability','whoswhoindisability','worldsdisabilitydirectory','worlddisabilitysearchengine');
    $tourism_sitename_array=array('allabouttourism','atozoftourism','besttourismbusinesses','everythingabouttourism','top100intourism','tourismalist','tourismbestbuys','tourismsearchengine','whoswhointourism','worldstourismdirectory','worldtourismsearchengine');

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
    
    if (isset($_COOKIE["site"])){
        $site=$_COOKIE["site"];
    }else{

        if (in_array($site_name,$finance_sitename_array)){
            $site="finance";
            setcookie("site","finance");
        }
        if (in_array($site_name,$disability_sitename_array)){
            $site="disability";
            setcookie("site","disability");
        }
        if (in_array($site_name,$tourism_sitename_array)){
            $site="tourism";
            setcookie("site","tourism");
        }
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
echo $site_colour;
    switch ($site_colour){
        case "Red":
            $colour1='#F03C02';
            $colour2='#A30006';
            break;
        case "Blue":
            $colour1='#3498db';
            $colour2='#2980b9';
            break;
    }

// concatenate the variables into a string
    $choose_wallpaper=$site_key."_".$site_colour."_".$choose_wallpaper.".jpg";

// destroy some of the variables 
    unset ($query);
    unset ($result);
    unset ($row);
    unset ($site_name);
    unset ($link_array);
    unset ($actual_link);

    header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
    header('Pragma: no-cache'); // HTTP 1.0.
    header('Expires: 0'); // Proxies.
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
            background: <?php echo $colour1; ?>;
            background-image: -webkit-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: -o-linear-gradient(top, <?php echo $colour1.",".$colour2; ?>);
            background-image: linear-gradient(to bottom, <?php echo $colour1.",".$colour2; ?>);
            -webkit-border-radius: 4;
            -moz-border-radius: 4;
            border-radius: 4px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 5px 10px 5px 10px;
            text-decoration: none;
        }

 /*       .btn:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
        }*/

/* This button was generated using CSSButtonGenerator.com*/
        
    </style>
</head>

<body>

<table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td height="164" background="<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
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
        <td height="100%" class="stretch" valign="top">
            <center>

                <form name="index" action="list.php" method="POST">

                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td><img src="trans.gif" width="1" height="10"></td>
                        </tr>
                        <tr>
                            <td><img src="fade_left.png"></td>
                            <td background="fade_middle.png"> <font color="#ffffff">Add your website</font> </td>
                            <td><img src="fade_right.png"></td>
                        </tr>
                    </table><p>

                    <!-- <a href="#" class="btn">TEXT</a><p> -->

                    <select name="cboCountryCode" class="btn">
                        <option value="none">Choose Country</option>

<?php

    $query="select * from countries order by country_name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

        echo ("<option value=\"".$row["country_code"]."\">".$row["country_name"]."</option>\n");

    }

?>

                    </select>

                    <select name="category" class="btn">
                        <option value="none">Choose Category</option>

<?php

    $query="select * from vCategory where sitekey='".$site."' order by categdesc asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

        echo ("<option value=\"".$row["categid"]."\">".$row["categdesc"]."</option>\n");

    }

?>

                    </select><img src="trans.gif" width="4" height="1"><input type="submit" class="btn"></select></center>
        </td>
    </tr>
</table>
</body>