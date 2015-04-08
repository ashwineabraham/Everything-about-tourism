<head>
    <script type="text/javascript">
            window.onblur=function(){self.close();};
    </script>
    <style>
        * {
            font-family: helvetica;
        }
    </style>
</head>

<body>
    
    <table>
        
<?php

    include ("dbconnect.php");
    
// get the recorded activity for this user
    $query="select * from user_log where user_id='".$_GET["user_id"]."' order by timestamp desc;";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

// convert the date to a human readable format
        $activity_date=date('d-m-Y H:i:s',$row["timestamp"]);

// start a new row
        echo ("<tr>");

// default bacground colour is white        
        $bgcolor="#ffffff";
        
// check for activities important enough to colour code
        switch ($row["action"]){

// blue
            case "holding1":
                $bgcolor="#50ABD2";
                break;

// green
            case "USER LOGIN":
                $bgcolor="#78B653";
                break;

// yellow
            case "holding2":
                $bgcolor="#CAD04F";
                break;

// orange
            case "holding3":
                $bgcolor="#ED913D";
                break;

// red
            case "holding4":
                $bgcolor="#E8182E";
                break;
        }
        
// write out the activities with colour coding if required
        echo ("<td>".$activity_date."</td><td bgcolor=\"".$bgcolor."\">".$row["action"]."</td>");
        
// finish the row
        echo ("</tr>");
                
    }
    
?>

    </table>
    
</body>
