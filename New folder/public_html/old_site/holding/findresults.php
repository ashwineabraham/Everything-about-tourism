<font face="arial" size="-1">

<?php

	include ("dbconnect.php");

	$site=strtoupper($_POST["site"]);

// check for matching keywords

	$query="select count(*) as counted from provider where sitekey='".$site."' and providername like '%".$_POST["searchq"]."%' and providerstatus not like 'Pending' and providername is not null;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	
    	$matched=$row["counted"];
    
    }

	if (($matched>0)and($matched<50)){

		$query="select providername from provider where sitekey='".$site."' and providername like '%".$_POST["searchq"]."%' and providerstatus not like 'Pending' and providername is not null order by providername asc;";
		
		echo ("<table>");
//		$query="select attraction_keywords from attractions where attraction_keywords like '%".$_POST["searchq"]."%';";
	    
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	
	    	$providername=strtolower($row["providername"]);
	    	$providername=ucwords($providername);

	    	echo "<tr><td valign=\"top\"><img src=\"images/balloon-box-left.png\" border=\"0\"></td><td><font face=\"arial\" size=\"-1\">".$providername."</font></td></tr>";
	    }
	    echo ("</table>");
	}

	if ($matched>50){
	    echo ("Too many (".$matched.")");
	}

	if ($matched<1){
	    echo ("No matches");
	}

?>

</font>
