<table cellpadding="0" cellspacing="0">

<?php

	include ("dbconnect.php");

	// $query="select * from contractor_details order by contractor_top, contractor_mid, contractor_base;";
	// $result=mysql_query($query);
	// while ($row = mysql_fetch_array($result)) {

	// 	if (($row["contractor_mid"]==0)and($row["contractor_base"]==0)){
	// 		echo ("<tr><td><img src=\"images/".$row["contractor_photo"]."_small.jpg\"></td><td valign=\"top\" colspan=\"4\">".$row["contractor_name"]."</td></tr>\n");
	// 	}

	// 	if (($row["contractor_mid"]>0)and($row["contractor_base"]==0)){
	// 		echo ("<tr><td><img src=\"images/tree.gif\"></td><td><img src=\"images/".$row["contractor_photo"]."_small.jpg\"></td><td valign=\"top\" colspan=\"3\">".$row["contractor_name"]."</td></tr>\n");
	// 	}

	// 	if (($row["contractor_mid"]>0)and($row["contractor_base"]>0)){
	// 		echo ("<tr><td><img src=\"images/vertical.gif\"></td><td><img src=\"images/right.gif\"></td><td><img src=\"images/".$row["contractor_photo"]."_small.jpg\"></td><td valign=\"top\" colspan=\"2\">".$row["contractor_name"]."</td></tr>\n");
	// 	}

	// }

?>

</table>