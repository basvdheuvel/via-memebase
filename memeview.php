<!DOCTYPE html>
<?php 
	if(!isset($_GET['id'])) die;
	$db = new mysqli('localhost', 'xxxxx', 'xxxxx', 'xxxxx');
	$id = $db->real_escape_string($_GET['id']);
	$res = $db->query("SELECT * FROM memes WHERE id=$id");
	$row_cnt = $res->num_rows;
	if($row_cnt == 0) {
		echo "Geen resultaten.";
		die;
	}
	$row = $res->fetch_assoc();
	$title = $row['top'] . " " . $row['bottom'];
?>
<html>
 <head>
 <meta property="og:image" content="meme.php?id=<?php echo $id ?>" />
 <meta property="og:image:width" content="300" /> 
<meta property="og:image:height" content="300" />
  <meta charset="UTF-8">
  <title><?php echo $title ?></title>
 </head>
 <body>
 <img src="meme.php?id=<?php echo $id ?>" />
 </body>
</html>