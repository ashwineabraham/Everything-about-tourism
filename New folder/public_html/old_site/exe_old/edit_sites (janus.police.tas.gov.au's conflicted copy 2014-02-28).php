<head>
    <style type="text/css">
	* {
	    font-family: helvetica;
	    font-size:12px;
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

<form name="choose_site" method="POST" action="edit_sites.php">

	<table>
		<tr>
			<td>Show me the</td>
			<td>
			    <select name="site_colour">
			    	<option value=''>Choose a colour</option>
			    	<option value="all">All Colours</option>
					<option value="black">BLACK</option>
					<option value="blue">BLUE</option>
					<option value="darkblue">DARK BLUE</option>
					<option value="green">GREEN</option>
					<option value="red">RED</option>
					<option value="yellow">YELLOW</option>
					<option value="white">WHITE</option>
			    </select>
			</td>
			<td>sites in</td>
			<td>
			    <select name="site_key" onchange="this.form.submit()">
			    	<option>Choose a site key</option>
					<option value="4x4">4x4</option>
					<option value="adventure">ADVENTURE</option>
					<option value="advertising">ADVERTISING</option>
					<option value="astrology">ASTROLOGY</option>
					<option value="collectables">COLLECTABLES</option>
					<option value="disability">DISABILITY</option>
					<option value="education">EDUCATION</option>
					<option value="finance">FINANCE</option>
					<option value="health">HEALTH</option>
					<option value="hunting">HUNTING</option>
					<option value="relationships">RELATIONSHIPS</option>
					<option value="sunglasses">SUNGLASSES</option>
					<option value="tourism">TOURISM</option>
					<option value="weddings">WEDDINGS</option>
			    </select>
			</td>
		</tr>
	</table>

</form>

<?php

// connect to the database
	include("dbconnect.php");

// check if the form has ben submitted
	if ($_POST){

// set a counter for use in the row colour check
		$rowcounter=0;

// start the table
		echo ("<table cellpadding=\"5\">");
		echo ("<tr>");
		echo ("<td colspan=\"2\"><center><b>Shown</b></center></td>");
		echo ("<td></td>");
		echo ("<td width=\"200\"><b>Site Domain Name</b></td>");
		echo ("<td width=\"120\" align=\"right\"><b>Site Category</b></td>");
		echo ("<td width=\"80\" align=\"right\"><b>Site Colour</b></td>");
		echo ("<td><b>Site Title Text</b></td>");
		echo ("<td><center><b>Delete</b></center></td>");
		echo ("</tr>");

// if the user has chosen to show all colours of a site category
		if (($_POST["site_colour"]==='all')or(empty($_POST["site_colour"]))){

// choose the query that ignores the colours but does sort by them
			$query="select * from site_details where site_key='".$_POST["site_key"]."' order by site_key, site_colour asc;";

// otherwise..
		}else{

// choose the query that uses the colour designation
			$query="select * from site_details where site_key='".$_POST["site_key"]."' and site_colour='".$_POST["site_colour"]."';";
		}

// perform the query
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {

// row bgcolour check.. even numbers will give a different colour
			if ($rowcounter%2==0){
				$bgcolor="#F8F6FF";
			}else{
				$bgcolor="#F1F3F7";
			}

	    	echo ("<tr>\n");
		
// if the site is not marked as hidden..
		if ($row["site_hidden"]=="no"){
		    echo ("<td><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>");
    		    echo ("<td bgcolor=\"#E9FCCF\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(50,50,50,'show_hide_site.php?show_hide=hide&site_id=".$row["site_id"]."','Hide ".$row["site_title"]."');\"><img src=\"images/tick.png\" title=\"Hide ".$row["site_title"]."\" border=\"0\"></a></td>");		    
		}else{

// give the user the option to unhide this site
		    echo ("<td bgcolor=\"#fb967F\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(50,50,50,'show_hide_site.php?show_hide=show&site_id=".$row["site_id"]."','Show ".$row["site_title"]."');\"><img src=\"images/cross.png\" title=\"Show ".$row["site_title"]."\" border=\"0\"></a></td>");
		    echo ("<td><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>");
		}
		
		echo ("<td><a href=\"javascript:void(0)\" onclick=\"CenterWindow(500,400,50,'edit_single_site.php?site_id=".$row["site_id"]."','Edit ".$row["site_title"]."');\"><img src=\"images/notebook--pencil.png\" title=\"Edit ".$row["site_title"]."\" border=\"0\"></a></td>\n");
		echo ("<td bgcolor=\"".$bgcolor."\">".$row["site_name"]."</td>\n");
		
// uppercase the first letter of the SITE KEY
		$row["site_key"]=ucfirst($row["site_key"]);
		
		echo ("<td bgcolor=\"".$bgcolor."\" align=\"right\">".$row["site_key"]."</td>\n");
		
// test to match the site colour with cell background
		switch ($row["site_colour"]){
		    case "black":
			$site_colour_bg="#aaaaaa";
			break;
		    case "blue":
			$site_colour_bg="#C5E0DC";
			break;
		    case "darkblue":
			$site_colour_bg="#88c2ba";
			break;
		    case "green":
			$site_colour_bg="#E9FCCF";
			break;
		    case "red":
			$site_colour_bg="#E8CAAF";
			break;
		    case "yellow":
			$site_colour_bg="#F7F972";
			break;
		    case "white":
			$site_colour_bg="#fafafa";
			break;
		    default:
			$site_colour_bg=$bgcolor;
		}
		
// uppercase the first letter of the SITE COLOUR
		$row["site_colour"]=ucfirst($row["site_colour"]);
		
		echo ("<td bgcolor=\"".$site_colour_bg."\" align=\"right\">".$row["site_colour"]."</td>\n");
		echo ("<td bgcolor=\"".$bgcolor."\">".$row["site_title"]."</td>\n");

		switch ($row["site_deleted"]){
			case "no":
				echo ("<td><center><img src=\"images/scissors.png\" width=\"16\" height=\"16\"></center></td>");
				break;
			case "yes":
				echo ("<td><center><img src=\"images/tick.png\" width=\"16\" height=\"16\"></center></td>");
				break;
			case "pending":
				echo ("<td><center><img src=\"images/clock.png\" width=\"16\" height=\"16\"></center></td>");
				break;
		}

		echo ("</tr>\n");

// increment the row counter
	    	$rowcounter++;

	    }

	    echo ("</table>");

	}

// destroy our variables
	unset ($query);
	unset ($rowcounter);
	unset ($bgcolor);
	unset ($result);
	unset ($row);
	unset ($site_colour_bg);

?>



</body>
