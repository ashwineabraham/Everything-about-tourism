<?php

	include ("dbconnect.php");

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

	switch ($site_key){
		case "finance":
			$colour="#822a25";
			break;
		case "tourism":
			$colour="#005186";
			break;
		default:
			$colour="#005186";
			break;
	}

?>

<head>

    <title><?php echo $site_title; ?></title>

    <style type="text/css">
        
        body{
            margin: 0;
            padding: 0
        }


        h1{
            font-family: verdana;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
            text-shadow: 3px 3px 2px rgba(150, 150, 150, 0.7);
            font-size: 52px;
        }
		
		font{
			font-size:14px;	
			font-weight:600;
			
			}
      
	  font.pn{
		 font-size:20px; 
		  }
        
        select {
            width:267px;
        }

        * {
            font-family: verdana;
        }
    </style>

    <script type="text/javascript">
        function gen_mail_to_link(lhs,rhs,subject){
            document.write("<A style=\"color: blue\" HREF=\"mailto");
            document.write(":" + lhs + "@");
            document.write(rhs + "?subject=" + subject + "\" style=\"color:yellow\">" + lhs + "@" + rhs + "<\/A>");
        } 
    </SCRIPT>
    
</head>

<body>

	<table width="100%" height="100%" cellspacing="0">
        <tr>
            
                <td colspan="3" height="164" background="images/<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
                
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                    <tr>
                        <td valign="middle"><a href="index.php" style="text-decoration:none;"> <h1><?php echo $site_title; ?></h1> </a></td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                </table></center>

            </td>
        </tr>
  		<tr>

<!-- left column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200" height="1"></td>
            
<!-- content column -->

			<td valign="top">
				<table>
					<tr>
						<td>

                            <font  class="pn" face="verdana" size="+2"><center><b>ABOUT US</b></font><p>

                            <font >The "World Specialized Search Engines" were formed when expert internet people involved in the tourism Industry found it hard to find the exact web sites they required to search on the internet, even via the likes of the generic search websites like Google, Yahoo, Bing etc.</font><p>

                            <font >These Internet Industry Specialists sometimes were taking up to 10-15 minutes to find various Categories in certain Countries under different Topics, with so many irrelevant website results shown to them.</font><p>

                            <font >Enter ... The "World's Specialized Search Engines"!</font><p>

                            <font >... The Simple and Easy Way to find whatever you require around the World, all listed in alphabetical order.</font><p>
                             
                            <font >There are over 500 International Specific Search Engines, all under the umbrella of "The World Specialized Search Engines" with the latest Search Engine Directories, only recently launched, can be viewed on the famous www.EverythingAboutEverything.com website.</font><p>

                            <font >If you wish to be involved with creating any of our new Specific and Specialized World Search Engine Directories under any Topic, please email 

                            <SCRIPT LANGUAGE="JavaScript" type="text/javascript">
                            gen_mail_to_link('manager','worldspecializedsearchengines.com','About Us Request')
                            </SCRIPT>
                            <NOSCRIPT>
                            <em>Email address protected by JavaScript. Activate javascript to see the email.</em>
                            </NOSCRIPT>

                            </font><p>

                            <font >All contact details can be viewed on the adjacent "Contact Us" button.</font>

                        </td>
					</tr>
				</table>
			</td>

<!-- right column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200"></td>
		</tr>
	</table>

</body>