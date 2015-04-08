<?php
include('config.php');
$page = (int) (!isset($_GET['p'])) ? 1 : $_GET['p'];
# sql query
$sql = "SELECT * FROM actor_info ORDER BY id DESC";
# find out query stat point
$start = ($page * $limit) - $limit;
# query for page navigation
if( mysql_num_rows(mysql_query($sql)) > ($page * $limit) ){
	$next = ++$page;
}
$query = mysql_query( $sql . " LIMIT {$start}, {$limit}");
if (mysql_num_rows($query) < 1) {
	header('HTTP/1.0 404 Not Found');
	echo 'Page not found!';
	exit();
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>jQuery Load While Scroll</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ias.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        	// Infinite Ajax Scroll configuration
            jQuery.ias({
                container : '.wrap', // main container where data goes to append
                item: '.item', // single items
                pagination: '.nav', // page navigation
                next: '.nav a', // next page selector
                loader: '<img src="css/ajax-loader.gif"/>', // loading gif
                triggerPageThreshold: 3 // show load more if scroll more than this
            });
        });
    </script>
</head>
<body>
<div class="wrap">
	<h1><a href="#">Data load while scroll</a></h1>

	<!-- loop row data -->
	<?php while ($row = mysql_fetch_array($query)): ?>
	<div class="item" id="item-<?php echo $row['id']?>">
		<h2>
			<span class="num"><?php echo $row['id']?></span>
			<span class="name"><?php echo $row['first_name'].' '.$row['last_name']?></span>
		</h2>
		<p><?php echo $row['film_info']?></p>
	</div>
	<?php endwhile?>

	<!--page navigation-->
	<?php if (isset($next)): ?>
	<div class="nav">
		<a href='index.php?p=<?php echo $next?>'>Next</a>
	</div>
	<?php endif?>
</div><!--.wrap-->
</body>
</html>