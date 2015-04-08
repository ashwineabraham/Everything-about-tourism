<table cellpadding="10">
	<tr>
		<td valign="top">
<?php

// connect to the database
	include ("dbconnect.php");

// create a form
	echo ("<form name=\"select_type\" method=\"POST\" action=\"all_providers.php\">"); 

// start a SELECT dropdown option with an onchange trigger
	echo ("<select NAME=\"sitekey\" size=\"1\" id=\"sitekey\" onchange=\"this.form.submit()\">");
	echo ("<option value=\"\">Choose a site</option>");

// grab a list of the unique SITEKEY variables ordered alphabetically
	$query="select distinct(sitekey) as sitekey from provider where sitekey != '' order by sitekey asc;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		
// create an option for each
		echo ("<option value=\"".$row["sitekey"]."\"");
		
// check to see which one is currently selected and make that the default
		if ($_POST["sitekey"]==$row["sitekey"]){
			echo (" selected");
		}
	
		echo (">".$row["sitekey"]."</option>\n");
	}
	echo ("</select>");

// close the form
	echo ("</form>");

?>

			<a href="#a">a</a><br>
			<a href="#b">b</a><br>
			<a href="#c">c</a><br>
			<a href="#d">d</a><br>
			<a href="#e">e</a><br>
			<a href="#f">f</a><br>
			<a href="#g">g</a><br>
			<a href="#h">h</a><br>
			<a href="#i">i</a><br>

		</td><td valign="top">

<?php

// create a counter
	$counter=0;
	
// get an alphabetical list of all businesses in this SITEKEY
	$query="select distinct(providername) as providername from provider where sitekey = '".$_POST["sitekey"]."' order by sitekey asc;";
	$result=mysql_query($query);
	while ($row = mysql_fetch_array($result)) {

// if the returned business name is only numbers and if so disregard it
		if (is_numeric($row["providername"])){
			
// if it passes the mixed character test then write it out
			echo $row["providername"]."<br>";
			
// increment the counter
			$counter++;
		}
		
// if the counter has reached 30
		if ($counter===30){
			
// if so then start a new column
			echo ("<img src=\"images/trans.gif\" width=\"300\" height=\"1\"></td><td valign=\"top\" width=\"300\">");
			
// reset the counter to zero
			$counter=0;
		}
	}

?>

		<img src="images/trans.gif" width="300" height="1"></td>
	</tr>
</table>