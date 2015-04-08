<head>
    <style type="text/css">
		body{
			background:url('world-map.gif') center center no-repeat;
		}
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

// get the current time stamp
	$time_now=time();

// get the user ID associated with this hash - dont want to pass as a cookie value in case it might be spoofed
	$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// if no action has been performed..
		if (!isset($_POST["site_key"])){

// update the user log with this action
	    	mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='ACCESS DOMAIN EDIT PAGE', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");

// otherwise
		} else {

// update the log with the users chosen list
	    	mysql_query("insert into user_log set user_id='".$row["user_id"]."', action='USER ACCESSED ".$_POST["site_key"]." LIST', timestamp='".$time_now."', md5='".$_COOKIE["admin_md5"]."';");
		}
	}

// check if the form has ben submitted
	if ($_POST){

// set a counter for use in the row colour check
		$rowcounter=0;

// start the table
		echo ("<table cellpadding=\"5\">");
		echo ("<tr>");
		echo ("<td colspan=\"2\"><center><b>Shown</b></center></td>");
		echo ("<td></td>");
		echo ("<td></td>");
		echo ("<td width=\"200\"><b>Site Domain Name</b></td>");
		echo ("<td><b>Site Title Text</b></td>");
		echo ("<td><img src=\"images/scissors.png\" title=\"Delete sites\"></td>");
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

// start a new table row
	    	echo ("<tr>\n");
		
// if the site is not marked as hidden..
		if ($row["site_hidden"]=="no"){
		    echo ("<td><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>");

// show a green tick and give the option to hide this site
    		    echo ("<td bgcolor=\"#E9FCCF\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(50,50,50,'show_hide_site.php?show_hide=hide&site_id=".$row["site_id"]."','Hide ".$row["site_title"]."');\"><img src=\"images/tick.png\" title=\"Hide ".$row["site_title"]."\" border=\"0\"></a></td>");		    
		}else{

// otherwise show a red cross and give the user an option to relist the site
		    echo ("<td bgcolor=\"#fb967F\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(50,50,50,'show_hide_site.php?show_hide=show&site_id=".$row["site_id"]."','Show ".$row["site_title"]."');\"><img src=\"images/cross.png\" title=\"Show ".$row["site_title"]."\" border=\"0\"></a></td>");
		    echo ("<td><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>");
		}

// show an edit site icon that fires a popup with site editing options
		echo ("<td><a href=\"javascript:void(0)\" onclick=\"CenterWindow(500,400,50,'edit_single_site.php?site_id=".$row["site_id"]."','Edit ".$row["site_title"]."');\"><img src=\"images/notebook--pencil.png\" title=\"Edit ".$row["site_title"]."\" border=\"0\"></a></td>\n");

// test to match the site colour with cell background
		switch ($row["site_colour"]){
		    case "black":
			$site_colour_bg="#474747";
			break;
		    case "blue":
			$site_colour_bg="#C0D9D9";
			break;
		    case "darkblue":
			$site_colour_bg="#00868B";
			break;
		    case "green":
			$site_colour_bg="#66CD00";
			break;
		    case "red":
			$site_colour_bg="#E3170D";
			break;
		    case "yellow":
			$site_colour_bg="#FFD700";
			break;
		    case "white":
			$site_colour_bg="#fafafa";
			break;
		    default:
			$site_colour_bg=$bgcolor;
		}
		
// uppercase the first letter of the SITE COLOUR
		$row["site_colour"]=ucfirst($row["site_colour"]);
		
		echo ("<td bgcolor=\"".$site_colour_bg."\"><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>\n");

		echo ("<td bgcolor=\"".$bgcolor."\"><font color=\"#bcbcbc\">www.</font><font color=\"#000000\">".$row["site_name"]."</font><font color=\"#bcbcbc\">.com</font></td>\n");
		
// uppercase the first letter of the SITE KEY
		echo ("<td bgcolor=\"".$bgcolor."\">".$row["site_title"]."</td>\n");

// check the sites deleted status and siplay appropriate icon
		switch ($row["site_deleted"]){
			case "no":
				echo ("<td bgcolor=\"#FFE4E1\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(400,150,50,'delete_site.php?site_id=".$row["site_id"]."','Mark ".$row["site_title"]." for Deletion');\"><img src=\"images/trans.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"Mark ".$row["site_title"]." for Deletion\" onmouseover=\"this.src='images/scissors.png';\" onmouseout=\"this.src='images/trans.gif';\"></a></td>");
				break;
			case "yes":
				echo ("<td bgcolor=\"#fb967F\"><center><img src=\"images/cross.png\" width=\"16\" height=\"16\" title=\"This site has been deleted\"></center></td>");
				break;
			case "pending":
				echo ("<td bgcolor=\"#A4D3EE\"><center><img src=\"images/clock.png\" width=\"16\" height=\"16\" title=\"This site is pending deletion by the moderators\"></center></td>");
				break;
			default:
				echo ("<td bgcolor=\"#FFE4E1\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(400,150,50,'delete_site.php?site_id=".$row["site_id"]."','Mark ".$row["site_title"]." for Deletion');\"><img src=\"images/trans.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"Mark ".$row["site_title"]." for Deletion\" onmouseover=\"this.src='images/scissors.png';\" onmouseout=\"this.src='images/trans.gif';\"></a></td>");
				break;
		}
 
		echo ("</tr>\n");

// increment the row counter
	    	$rowcounter++;

	    }

// finish the table
	    echo ("</table>");

	}

// destroy our variables
	unset ($query);
	unset ($rowcounter);
	unset ($bgcolor);
	unset ($result);
	unset ($row);
	unset ($site_colour_bg);
	unset ($time_now);

?>

</body>
