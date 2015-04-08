<head>
<style type="text/css">
    body{
        margin: 0;
        padding: 0
    }
</style>
</head>
<body>
	<table width="100%" height="100%">
		<tr>
			<td valign="middle" width="100%" height="100%"><center><img src="maintenance3.png"></center></td>
		</tr>
	</table>
</body>

<?php

	function getUserIP()
	{
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

	    return $ip;
	}
	
// connect to the database
	include ("dbconnect.php");

// get the URL requested by the client
	$actual_link = $_SERVER[HTTP_HOST];

// deconstruct the URL using the "." as a delimter
	$link_array=explode('.',$actual_link);

// if the first array value is "www"..
	if ($link_array[0]==='www'){

// then use the second array value to test with
		$site_image=$link_array[1];
	}else{

// otherwise the www is issing and the first array value holds the site name
		$site_image=$link_array[0];
	}

	$ip_address=getUserIP();
	
	$timenow=time();

	$country=file_get_contents("http://freegeoip.net/json/".$ip_address);

	$explode=explode(',',$country);

	$country_name_array=explode(':',$explode[2]);
	$country_name_full=$country_name_array[1];

	$country_code_array=explode(":",$explode[1]);
	$country_code_full=$country_code_array[1];

	$country=$country_name_full." (".$country_code_full.")";
	$country=str_replace('"', "", $country);

	mysql_query("insert into visitor_log set site='".$site_image."', ip_address='".$ip_address."', ip_address_proxy='".$ip_address_proxy."', country='".$country."', timestamp='".$timenow."';");

	unset ($actual_link);
	unset ($link_array);
	unset ($site_image);
	unset ($ip_address);
	unset ($timenow);
	unset ($country);
	unset ($explode);
	unset ($country_name_array);
	unset ($country_name_full);
	unset ($country_code_array);
	unset ($country_code_full);
	unset ($country);

?>