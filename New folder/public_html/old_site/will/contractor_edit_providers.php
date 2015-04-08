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

	<table>
		<tr>
			<td valign="top" width="35%">
  				<font face="arial" size="-1"><b>Instructions</b><p>You can toggle the visibiity of your providers in the SHOWN column.  A green tick shows that the provider is visible in the list while a red cross denotes that it is hidden.<p>Clicking the notepad icon will allow you to edit some aspects of the providers record such as contact details.<p>You can mark the record for deletion by clicking on the scissors icon.  Note that this will not delete the record but mark it as pending pursuant to an administrators approval.  A provider marked for deletion will have a clock icon shown here.</b></font>
  			</td>
  			<td><img src="images/trans.gif" width="20" height="1"></td>
  			<td valign="top">

<?php

// connect to the database
	include("dbconnect.php");

// get the current time stamp
	$time_now=time();

	if (isset($_GET["shown"])){
		mysql_query("update new_entries set provider_visible='".$_GET["shown"]."' where id = '".$_GET["provider_id"]."';");
		echo ("<meta http-equiv=\"refresh\" content=\"10;contractor_edit_providers.php\">");
	}

// get the user ID associated with this hash - dont want to pass as a cookie value in case it might be spoofed
	$query="select distinct(user_id) from user_log where md5='".$_COOKIE["admin_md5"]."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// store the user ID for later
		$user_id=$row["user_id"];
	}

// set a counter for use in the row colour check
	$rowcounter=0;

// start the table
	echo ("<table cellpadding=\"5\">");
	echo ("<tr>");
	echo ("<td colspan=\"2\"><center><b>Visible</b></center></td>");
	echo ("<td></td>");
	echo ("<td></td>");
	echo ("<td width=\"200\"><b>Provider Name</b></td>");
	echo ("<td><img src=\"images/scissors.png\" title=\"Remove Provider\"></td>");
	echo ("</tr>");

// get the data from the new_entries table
	$query="select * from new_entries where contractor_id='".$user_id."' order by time_submitted desc;";

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
	
// if the site is not marked as pending deletion..
		if ($row["provider_visible"]==="yes"){

// show a green tick and give the option to hide this site
		    echo ("<td><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>");
    		echo ("<td bgcolor=\"#E9FCCF\"><a href=\"contractor_edit_providers.php?shown=no&provider_id=".$row["id"]."\"><img src=\"images/tick.png\" title=\"Hide ".$row["site_title"]."\" border=\"0\"></a></td>");		    
		}else{

// otherwise show a red cross and give the user an option to relist the site
		    echo ("<td bgcolor=\"#fb967F\"><a href=\"contractor_edit_providers.php?shown=yes&provider_id=".$row["id"]."\"><img src=\"images/cross.png\" title=\"Show ".$row["site_title"]."\" border=\"0\"></a></td>");
		    echo ("<td><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>");
		}

// show an edit site icon that fires a popup with site editing options
		echo ("<td><a href=\"javascript:void(0)\" onclick=\"CenterWindow(800,400,50,'contractor_edit_provider.php?provider_id=".$row["id"]."','Edit ".$row["business_name"]."');\"><img src=\"images/notebook--pencil.png\" title=\"Edit ".$row["business_name"]."\" border=\"0\"></a></td>\n");

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
				break;
		}
		
// uppercase the first letter of the SITE COLOUR
		$row["site_colour"]=ucfirst($row["site_colour"]);
		
		echo ("<td bgcolor=\"".$site_colour_bg."\"><img src=\"images/trans.gif\" width=\"16\" height=\"16\"></td>\n");

		echo ("<td bgcolor=\"".$bgcolor."\"><font color=\"#000000\">".$row["business_name"]."</font></td>\n");
		
// uppercase the first letter of the SITE KEY
//		echo ("<td bgcolor=\"".$bgcolor."\">".$row["site_title"]."</td>\n");

// check the sites deleted status and siplay appropriate icon
		switch ($row["site_deleted"]){
			case "no":
				echo ("<td bgcolor=\"#FFE4E1\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(400,150,50,'contractor_delete_provider.php?provider_id=".$row["id"]."','Mark ".$row["business_name"]." for removal');\"><img src=\"images/trans.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"Mark ".$row["business_name"]." for removal\" onmouseover=\"this.src='images/scissors.png';\" onmouseout=\"this.src='images/trans.gif';\"></a></td>");
				break;
			case "yes":
				echo ("<td bgcolor=\"#fb967F\"><center><img src=\"images/cross.png\" width=\"16\" height=\"16\" title=\"This provider has been deleted\"></center></td>");
				break;
			case "pending":
				echo ("<td bgcolor=\"#A4D3EE\"><center><img src=\"images/clock.png\" width=\"16\" height=\"16\" title=\"This provider is pending deletion by the moderators\"></center></td>");
				break;
			default:
				echo ("<td bgcolor=\"#FFE4E1\"><a href=\"javascript:void(0)\" onclick=\"CenterWindow(400,150,50,'contractor_delete_provider.php?provider_id=".$row["id"]."','Mark ".$row["business_name"]." for removal');\"><img src=\"images/trans.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"Mark ".$row["business_name"]." for removal\" onmouseover=\"this.src='images/scissors.png';\" onmouseout=\"this.src='images/trans.gif';\"></a></td>");
				break;
		}
 
		echo ("</tr>\n");

// increment the row counter
	    	$rowcounter++;
	    }

// finish the table
	    echo ("</table>");

// destroy our variables
	unset ($query);
	unset ($rowcounter);
	unset ($bgcolor);
	unset ($result);
	unset ($row);
	unset ($site_colour_bg);
	unset ($time_now);

?>

</td></tr></table>

</body>
