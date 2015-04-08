<head>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0
        }

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
            font-family: titilliumregular;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
            text-shadow: 3px 3px 2px rgba(150, 150, 150, 0.7);
            font-size: 52px;
        }

        body{
            margin: 0;
            padding: 0
        }
		select {
			width:267px;
		}

        * {
            font-family: helvetica;
        }
    </style>
</head>

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
	
<body>

	<table width="100%" height="100%" cellspacing="0">
        <tr>
            
                <td colspan="3" height="164" background="<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
                
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

<!-- left column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200" height="1"></td>

<!-- content column -->

			<td valign="top">
				<table>
					<tr>
						<td>

<?php

	switch ($site_key){
		case "finance":
			include ("contact_us_finance.inc");
			break;
		case "tourism":
			include ("contact_us_tourism.inc");
			break;
		default:
			break;		
	}
?>

</td>
					</tr>
				</table>
			</td>

<!-- right column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200"></td>
		</tr>
	</table>

</body>