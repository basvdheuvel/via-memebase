<?php
    include 'config.php';
?>
<!DOCTYPE html>

<html>
 <head>
  <meta charset="UTF-8">
  <title>Bekijk alle memes van een persoon</title>
 </head>
 <body>
 	<?php
	if(!isset($_GET['id'])) die;
	$id = $db->real_escape_string($_GET['id']);
	$res = $db->query("SELECT * FROM memes WHERE template=$id ORDER BY id DESC");
	$row_cnt = $res->num_rows;
	if($row_cnt == 0) {
		echo "Geen resultaten.";
		die;
	}
	while($row = $res->fetch_assoc()) {
		echo "<img src='meme.php?id=" . $row['id'] . "' /><br /><br />";
	}
?>
 </body>
</html>
