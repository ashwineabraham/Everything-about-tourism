<body topmargin="0" leftmargin="0" rightmargin="100" marginheight="0" marginwidth="0" background="images/main_bg.gif">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td bgcolor="#457CAB" background="images/top_bg.gif">

<?php 
	if (!$_GET){ 
		echo "<img src=\"images/title_everything.jpg\" align=\"left\">"; 
	}else{ 
		echo "<img src=\"images/title_".$_GET["site"].".jpg\" align=\"left\">";  
	}
?>

<a href="index.php" target="_top"><img src="images/home.gif" align="right" border="0"></a></td>
    </tr>
</table>