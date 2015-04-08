<?php

// set the expiration date to one hour ago

	unset($_COOKIE['site']);
 	setcookie('site', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["cboCountryCode"]);
 	setcookie('cboCountryCode', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["cboCountryName"]);
 	setcookie('cboCountryName', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["cboStateCode"]);
 	setcookie('cboStateCode', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["category"]);
 	setcookie('category', '', time() - 3600); // empty value and old timestamp
	unset ($_COOKIE["region"]);
 	setcookie('region', '', time() - 3600); // empty value and old timestamp

	include ("welcome1.php");
?>
