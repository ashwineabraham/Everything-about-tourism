<?php

	include ("dbconnect.php");

	$site='';
	$country_code='';
	$country_name='';
	$region='';
	$category='';

	if (isset($_COOKIE["site"])){
		$site=strtoupper($_COOKIE["site"]);
	}

	if (isset($_COOKIE["cboCountryCode"])){
		$country_code=$_COOKIE["cboCountryCode"];
	}

	if (isset($_COOKIE["cboCountryName"])){
		$country_name=$_COOKIE["cboCountryName"];
	}

	if (isset($_COOKIE["cboStateCode"])){
		$region=$_COOKIE["cboStateCode"];
	}

	if (isset($_COOKIE["category"])){
		$category=$_COOKIE["category"];
	}

	echo "Site - ".$site."<br>Category - ".$category."<br> Country - ".$country_name."<br>Code - ".$country_code."<br>Region - ".$region."<p>";
	
//	echo ("<table>");

// 	if (isset($_COOKIE["category"])){

 		$x=1;
// 		$y=1;

		$string='';

 		$query="select distinct(websiteid) as websiteid from WebSiteCategory where categid='".$category."';";
 		$result=mysql_query($query);
 		while ($row = mysql_fetch_array($result)) {
			
			$string=$string."'".$row["websiteid"]."',";

			$x++;

		}

		$string=rtrim($string, ",");

//		echo $x." -> ".$string."<p>";

		echo ("<table>");
			
		$query="select providerid, providername, sitekey, providercity from provider where 
			providerid in (".$string.") and 
			providerstatus = 'Free' and 
			providername <> '' and 
			sitekey = '".strtoupper($site)."' and 
			providerstatecode='".$region."' and 
			providercountrycode = '".$country_code."' 
			order by providername asc;";
//		echo $query."<p>";
		$result=mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
//			$query3="select website from website where providerid='".$row["websiteid"]."';";
//			$result3=mysql_query($query3);
//			while ($row3 = mysql_fetch_array($result3)) {
//				$website=$row3["website"];
//			}

			echo "<tr><td><font face=\"arial\" size=\"-1\">".$row["providername"]."</td><td><font face=\"arial\" size=\"-1\">".$row["providercity"]."</td><td><font face=\"arial\" size=\"-1\" color=\"#bcbcbcb\">(".$row["providerid"]." - ".$row["sitekey"].")</td></tr>\n";
		}

		echo ("</table>");
// 				echo $row2["providerid"]." (".$row2["providername"].") <- ".$y."<p>";
// 				$y++;
// //
// //				$query3="select website from website where providerid='".$row["websiteid"]."';";
// //				$result3=mysql_query($query3);
// //				while ($row3 = mysql_fetch_array($result3)) {
// //					$website=$row3["website"];
// //				}
// //				echo $query3."<p><hr><p>";
// //				echo ("<tr><td><font face=\"arial\" size=\"-1\">".$row2["providername"]." <font color=\"#bcbcbc\">(".$row["websiteid"].")</font></td><td><font face=\"arial\" size=\"-1\">".$row2["providercity"]."</font></td><td><font face=\"arial\" size=\"-1\">".$website."</font></td></tr>");
// // 	
// 			}
// 		}
// 		$y=1;
// 	}
	
// //	echo ("</table>");
?>