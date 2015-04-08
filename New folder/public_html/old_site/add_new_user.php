<?php

	include ("dbconnect.php");

	if ($_POST){


	} else { 

?>

<head>
    <style>
        * {
            font-family: helvetica;
            font-size: 12;
        }
    </style>
</head>

<body>

	<form name="create_new_user" action="add_new_user.php" method="POST">

		<table>
			<tr>
				<td>Firstname</td>
				<td><input name="firstname" type="text"></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><input name="lastname" type="text"></td>
			</tr>
			<tr>
				<td>Login Name</td>
				<td><input name="loginname" type="text"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="password1" type="password"></td>
			</tr>
			<tr>
				<td>Password again</td>
				<td><input name="password2" type="password"></td>
			</tr>
			<tr>
				<td>Country Represented</td>
				<td>
<?php

// create a blank string
	$string='';

// get a list of currently assigned countries
	$query="select distinct(country_represented) as country_represented from authorised_users;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// create a string with the 
    	$string=$string.",'".$row["country_represented"]."'";

    }

    echo $string;

    $string=substr($string, 1);

    echo "<p>".$string;

    echo ("<select name=\"country_represented\">");

    $query="select * from countries where country_enabled='TRUE' and country_code not in (".$string.") order by country_name asc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

    	echo ("<option value=\"".$row["country_code"]."\">".$row["country_name"]."</option>\n");

    }

    echo ("</select>");


?>			
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit"></td>
			</tr>
		</table>

	</form>

</body>

<?php
	
	}

?>