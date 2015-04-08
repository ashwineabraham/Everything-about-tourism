<body>
	<table>
	<tr>
		<td width="300">

			<form name="test" action="test.php" method="POST">

<?php

	include ("dbconnect.php");

	echo ("<input type=\"hidden\" name=\"site\" value=\"".$_GET["site"]."\">");

	echo ("<select NAME=\"cboCountryCode\" size=\"1\" onchange=\"this.form.submit()\">");
	echo ("<option value=\"\" selected>Choose a country</option>");
	echo ("<option value=\"all\">== All ==</option>");

	$query="select distinct(country_name) as counties from countries order by country_name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	echo ("<option value=\"".$row["counties"]."\"");

    	if ($_GET["cboCountryCode"]==$row["counties"]){
    		echo (" selected");
    	}

    	echo (">".$row["counties"]."</option>");
    }
    echo ("</select>");

	if ($_POST){
		$site=$_POST["site"];
	}else{
		$site=$_GET["site"];
	}

    echo ("<input type=\"hidden\" name=\"site\" value=\"".$site.">\"");

?>
</form>

		</td>
		<td valign="top">
			<form name="test2" action="list.php" method="GET" target="LIST">

<?php

	if (isset($_POST["cboCountryCode"])){

		echo ("<select NAME=\"cboStateCode\" size=\"1\">");
		echo ("<option value=\"\" selected>Choose a region</option>");
		echo ("<option value=\"all\">== All ==</option>");

		$query="select distinct(region) as regions from locations where country='".$_POST["cboCountryCode"]."' and region is not null order by region asc;";
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {
	    	echo ("<option value=\"".$row["regions"]."\">".$row["regions"]."</option>");
	    }
	    echo ("</select>");

	} else {
		echo ("<font face=\"arial\">Choose a country</font>");
	}

?>

		</td>
		<td valign="top">

<?php

	if ($_POST){
		$site=$_POST["site"];
	}else{
		$site=$_GET["site"];
	}

	echo ("<select NAME=\"category\" size=\"1\">");
	echo ("<option value=\"\" selected>Choose a category</option>");
	echo ("<option value=\"all\">== All ==</option>");

	$site=strtoupper($site);

	$query="select distinct(categdesc) as categories from vCategory where sitekey like '".$site."' order by categdesc asc;";
    
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    	echo ("<option value=\"".$row["categories"]."\">".$row["categories"]."</option>");
    }
    echo ("</select>");

?>

		</td>
		<td valign="top"><input type="submit"></td>
	</tr>
	</form>
</table>
</body>
