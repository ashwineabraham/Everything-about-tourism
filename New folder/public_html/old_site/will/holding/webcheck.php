<?php

       function Visit($url){
              $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
              $ch=curl_init();
              curl_setopt ($ch, CURLOPT_URL,$url );
              curl_setopt($ch, CURLOPT_USERAGENT, $agent);
              curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt ($ch,CURLOPT_VERBOSE,false);
              curl_setopt($ch, CURLOPT_TIMEOUT, 5);
              curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
              curl_setopt($ch,CURLOPT_SSLVERSION,3);
              curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
              $page=curl_exec($ch);
              $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              curl_close($ch);
              if($httpcode>=200 && $httpcode<400){
                     return true;
              }else{
                     return false;
              }
       }

       include ("dbconnect.php");

       $query="select count(*) as remaining from website where online not in ('no','yes');";
       $result=mysql_query($query) or die(mysql_error());
       while ($row = mysql_fetch_array($result)) {
              echo $row["remaining"]." remaining<p>";
       }

       $query="select * from website where online not in ('no','yes') limit 25;";

       echo $query."<p>";

       $result=mysql_query($query) or die(mysql_error());

       while ($row = mysql_fetch_array($result)) {

              $explode=explode("?", $row["WebSite"]);
              $row["WebSite"]=$explode[0];

              if (Visit($row["WebSite"])){
                     echo $row["WebSite"]." -> <font color=\"green\">OK</font>"."<br>\n";
                     mysql_query ("update website set online='yes' where WebSiteID='".$row["WebSiteID"]."';");
              }else{
                     echo $row["WebSite"]." -> <font color=\"red\">OFFLINE</font>"."<br>\n";
                     mysql_query ("update website set online='no' where WebSiteID='".$row["WebSiteID"]."';");
              }
       }
?>

<head>
       <META http-equiv="refresh" content="1;URL=webcheck.php">
</head>