<table border="0">

<?php

	include ("dbconnect.php");

	$time_now=time();

	if (isset($_GET["remove_site"])){
		mysql_query("update new_entries set site_deleted='yes', site_deleted_time='".$time_now."' where id='".$_GET["remove_site"]."';");
	}

	$query="select count(*) as unapproved_count from new_entries where approved='no';";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($row['unapproved_count']>0){
			echo ("<tr>");
			echo ("<td></td><td></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Business Name</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Address</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>City</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Country</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>State</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Postcode</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Contact</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Phone</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Mobile</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Fax</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Email</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Assoc_no</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Website</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Website_desc</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Category1</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Category2</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Category3</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Category4</b></font></td>");
			echo ("<td><font face=\"arial\" size=\"-1\"><b>Category5</b></font></td>");
			echo ("</tr>");
				
			$query2="select * from new_entries where approved='no' and business_name > '' and address > '' and city > '' and site_deleted != 'yes' order by business_name asc;";
			$result2=mysql_query($query2);
			while ($row2 = mysql_fetch_array($result2)) {
				
				if ($counter % 2 == 0){
					$bgcolor="#eaeaea";
				}else{
					$bgcolor="#ffffff";
				}
			
				echo ("<tr>");
				echo ("<td valign=\"top\"><img src=\"images/tick.png\" title=\"Approve ".$row2['business_name']." for publication\"></td><td valign=\"top\"><a href=\"show_new.php?remove_site=".$row2["id"]."\"><img src=\"images/cross.png\" title=\"Deny publication for ".$row2['business_name']."\" border=\"0\"></a></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['business_name']."</font></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['address']."</font></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['city']."</font></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['country']."</font></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['state']."</font></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['postcode']."</font></td>");
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['contact']."</font></td>");
				if ($row2["phone"]>''){
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/telephone-handset-wire.png\" title=\"".$row2['phone']."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["mobile"]>''){
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/mobile-phone.png\" title=\"".$row2['mobile']."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["fax"]>''){
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/telephone-fax.png\" title=\"".$row2['fax']."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["email"]>''){
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/mail.png\" title=\"".$row2['email']."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['assoc_no']."</font></td>");
				if ($row2["website"]>''){
					echo ("<td bgcolor=\"".$bgcolor."\"><a href=\"_new\" href=\"".$row2['website']."\"><img src=\"images/globe--arrow.png\" title=\"".$row2['website']."\" border=\"0\"></a></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["website_desc"]>''){
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/notebook--pencil.png\" title=\"".$row2['website_desc']."\"></td>");
				} else {
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");					
				}
				if ($row2["category1"]>0){
					$query3="select category_name from categories where category_id='".$row2["category1"]."';";
					$result3=mysql_query($query3);
					while ($row3 = mysql_fetch_array($result3)) {
						$category_name=$row3["category_name"];
					}
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/1.gif\" title=\"".$category_name." ".$row2["category1"]."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["category2"]>0){
					$query3="select category_name from categories where category_id='".$row2["category2"]."';";
					$result3=mysql_query($query3);
					while ($row3 = mysql_fetch_array($result3)) {
						$category_name=$row3["category_name"];
					}
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/2.gif\" title=\"".$category_name." ".$row2["category2"]."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["category3"]>0){
					$query3="select category_name from categories where category_id='".$row2["category3"]."';";
					$result3=mysql_query($query3);
					while ($row3 = mysql_fetch_array($result3)) {
						$category_name=$row3["category_name"];
					}
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/3.gif\" title=\"".$category_name." ".$row2["category3"]."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["category4"]>0){
					$query3="select category_name from categories where category_id='".$row2["category4"]."';";
					$result3=mysql_query($query3);
					while ($row3 = mysql_fetch_array($result3)) {
						$category_name=$row3["category_name"];
					}
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/4.gif\" title=\"".$category_name." ".$row2["category4"]."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				if ($row2["category5"]>0){
					$query3="select category_name from categories where category_id='".$row2["category5"]."';";
					$result3=mysql_query($query3);
					while ($row3 = mysql_fetch_array($result3)) {
						$category_name=$row3["category_name"];
					}
					echo ("<td bgcolor=\"".$bgcolor."\"><img src=\"images/5.gif\" title=\"".$category_name." ".$row2["category5"]."\"></td>");
				}else{
					echo ("<td bgcolor=\"".$bgcolor."\"></td>");
				}
				echo ("</tr>");
				
				$counter++;
				
			}			
		}else{
			echo ("<tr><td>No new applications</td></tr>");
		}
	}

?>

</table>