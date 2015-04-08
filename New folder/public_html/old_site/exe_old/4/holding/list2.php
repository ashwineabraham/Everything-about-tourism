<body>
	<font face="arial" size="-1">

<?php

	include ("dbconnect.php");

	if (isset($_GET["attraction_id"])){

		$query="select * from attractions where attraction_id='".$_GET["attraction_id"]."';";
	    
	    $result=mysql_query($query);
	    while ($row = mysql_fetch_array($result)) {

	    	echo "<b>".$row["attraction_name"]."</b><p>";

	    	$picture=strtolower($row["attraction_name"]);    	
	    	$picture=str_replace(' ', '_', $picture);

	    	$keywords=ucwords($row["attraction_keywords"]);    	
	    	$keywords=str_replace(' ', ', ', $keywords);
	    	
			echo ("<table>");
			echo ("<tr><td valign=\"top\"><img src=\"".$picture.".jpg\"></td><td valign=\"top\"><b>Keywords</b><p>".$keywords."</td></tr>");
			echo ("</table>");

		}
	} else {

		if (!isset($_GET["region"])){

			$query="select distinct(region) as regions from locations where region <>'' order by region asc;";
		    $result=mysql_query($query);
		    while ($row = mysql_fetch_array($result)) {
		    	echo "<a href=\"list.php?region=".$row["regions"]."\" style=\"text-decoration: none\">".$row["regions"]."</a><br>";
		    }

		 }else{

		 	$region=str_replace('%20', ' ', $_GET["region"]);

		 	$count_a=mysql_result(mysql_query("select count(*) as a_count from locations where region='".$region."' and name like 'a%';"),0);
		 	$count_b=mysql_result(mysql_query("select count(*) as b_count from locations where region='".$region."' and name like 'b%';"),0);
		 	$count_c=mysql_result(mysql_query("select count(*) as c_count from locations where region='".$region."' and name like 'c%';"),0);
		 	$count_d=mysql_result(mysql_query("select count(*) as d_count from locations where region='".$region."' and name like 'd%';"),0);
		 	$count_e=mysql_result(mysql_query("select count(*) as e_count from locations where region='".$region."' and name like 'e%';"),0);
		 	$count_f=mysql_result(mysql_query("select count(*) as f_count from locations where region='".$region."' and name like 'f%';"),0);
		 	$count_g=mysql_result(mysql_query("select count(*) as g_count from locations where region='".$region."' and name like 'g%';"),0);
		 	$count_h=mysql_result(mysql_query("select count(*) as h_count from locations where region='".$region."' and name like 'h%';"),0);
		 	$count_i=mysql_result(mysql_query("select count(*) as i_count from locations where region='".$region."' and name like 'i%';"),0);
		 	$count_j=mysql_result(mysql_query("select count(*) as j_count from locations where region='".$region."' and name like 'j%';"),0);
		 	$count_k=mysql_result(mysql_query("select count(*) as k_count from locations where region='".$region."' and name like 'k%';"),0);
		 	$count_l=mysql_result(mysql_query("select count(*) as l_count from locations where region='".$region."' and name like 'l%';"),0);
		 	$count_m=mysql_result(mysql_query("select count(*) as m_count from locations where region='".$region."' and name like 'm%';"),0);
		 	$count_n=mysql_result(mysql_query("select count(*) as n_count from locations where region='".$region."' and name like 'n%';"),0);
		 	$count_o=mysql_result(mysql_query("select count(*) as o_count from locations where region='".$region."' and name like 'o%';"),0);
		 	$count_p=mysql_result(mysql_query("select count(*) as p_count from locations where region='".$region."' and name like 'p%';"),0);
		 	$count_q=mysql_result(mysql_query("select count(*) as q_count from locations where region='".$region."' and name like 'q%';"),0);
		 	$count_r=mysql_result(mysql_query("select count(*) as r_count from locations where region='".$region."' and name like 'r%';"),0);
		 	$count_s=mysql_result(mysql_query("select count(*) as s_count from locations where region='".$region."' and name like 's%';"),0);
		 	$count_t=mysql_result(mysql_query("select count(*) as t_count from locations where region='".$region."' and name like 't%';"),0);
		 	$count_u=mysql_result(mysql_query("select count(*) as u_count from locations where region='".$region."' and name like 'u%';"),0);
		 	$count_v=mysql_result(mysql_query("select count(*) as v_count from locations where region='".$region."' and name like 'v%';"),0);
		 	$count_w=mysql_result(mysql_query("select count(*) as w_count from locations where region='".$region."' and name like 'w%';"),0);
		 	$count_x=mysql_result(mysql_query("select count(*) as x_count from locations where region='".$region."' and name like 'x%';"),0);
		 	$count_y=mysql_result(mysql_query("select count(*) as y_count from locations where region='".$region."' and name like 'y%';"),0);
		 	$count_z=mysql_result(mysql_query("select count(*) as z_count from locations where region='".$region."' and name like 'z%';"),0);

			$query="select distinct(name) as names from locations where region = '".$region."' order by name asc;";
			$result=mysql_query($query);
			while ($row = mysql_fetch_array($result)) {
//				echo "<a href=\"list.php?region=".$region."&name=".$row["names"]."\" style=\"text-decoration: none\">".$row["names"]."</a><br>";
			}

			echo $region." towns starting with..<p>";
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">A (".$count_a.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">B (".$count_b.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">C (".$count_c.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">D (".$count_d.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">E (".$count_e.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">F (".$count_f.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">G (".$count_g.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">H (".$count_h.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">I (".$count_i.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">J (".$count_j.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">K (".$count_k.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">L (".$count_l.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">M (".$count_m.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">N (".$count_n.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">O (".$count_o.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">P (".$count_p.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">Q (".$count_q.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">R (".$count_r.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">S (".$count_s.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">T (".$count_t.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">U (".$count_u.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">V (".$count_v.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">W (".$count_w.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">X (".$count_x.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">Y (".$count_y.")<br>");
			echo ("<a href=\"towns.php?region=".$region."&letter=a\" style=\"text-decoration: none\">Z (".$count_z.")");
		 }
	}

?>

</font>
</body>
