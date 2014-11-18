<?php
    include 'config.php';
?>
<html>
<head>
	<title>Memebase templates</title>
</head>

<body>
	<?php
	$res = $db->query("SELECT * FROM templates");
	while($row = $res->fetch_assoc()) {
		if($row['skip'] == 1) continue;
		$id = $row['id'];
		$url = $row['url'];
		$res2 = $db->query("SELECT naam FROM persons WHERE id=$id");
		$row2 = $res2->fetch_assoc();
		echo '<b>' . $row2['naam'] . ":</b><br />";
		echo '<img src="http://www.davidvanerkelens.nl/memebase/templates/' . $url . '" /><br /><br />';
	}
	$db->close();
	?>
</body>
</html>
