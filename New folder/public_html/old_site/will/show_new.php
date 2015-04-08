<table border="0">

<?php

	include ("dbconnect.php");

	$query="select count(*) as unapproved_count from new_entries where approved='no';";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($row['unapproved_count']>0){
				echo ("<tr>");
				echo ("<td><font face=\"arial\" size=\"-1\">Business Name</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Address</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">City</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Country</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">State</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Postcode</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Contact</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Phone</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Mobile</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Fax</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Email</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Assoc_no</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Website</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Website_desc</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Category1</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Category2</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Category3</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Category4</font></td>");
				echo ("<td><font face=\"arial\" size=\"-1\">Category5</font></td>");
				echo ("</tr>");
				
			$query2="select * from new_entries where approved='no' order by time_submitted asc;";
			$result2=mysql_query($query2);
			while ($row2 = mysql_fetch_array($result2)) {
				
				if ($counter % 2 == 0){
					$bgcolor="#eaeaea";
				}else{
					$bgcolor="#ffffff";
				}
			
				echo ("<tr>");
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
				echo ("<td bgcolor=\"".$bgcolor."\"><font face=\"arial\" size=\"-1\">".$row2['website_desc']."</font></td>");
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