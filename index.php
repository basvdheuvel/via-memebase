<?php
    include 'config.php';

    $tmp = $db->query("SELECT id FROM memes ORDER BY id DESC")->fetch_assoc();
    $latest_id = $tmp['id'];
?>
<html>
<head>
	<title>Memebase</title>
	<link href="style.css" type="text/css" rel="stylesheet"  />
</head>

<body>
	<?php
		if(isset($_POST['template'])) {
			$tem = trim($db->real_escape_string($_POST['template']));
			$t = trim($db->real_escape_string($_POST['top']));
			$b = trim($db->real_escape_string($_POST['bottom']));
			if(empty($t) && empty($b)) {
				echo "Er moet minimaal 1 caption opgegeven worden.";
				die;
			}
			$res = $db->query("SELECT * FROM memes WHERE template='$tem' AND top='$t' AND bottom='$b'");
			echo $db->error;
			if($res->num_rows > 0) {
				$tmp = $res->fetch_assoc();
				$id = $tmp['id'];
				echo "Deze meme bestaat al onder ID <a href='meme/$id.png'>$id</a>.<br />";
				die;
			}
			$db->query("INSERT INTO memes (template, top, bottom) VALUES ('$tem', '$t', '$b');");
			$id = $db->insert_id;
			echo "Meme ingevoegd. <a href='meme/$id.png'>link</a>";
			// echo "<pre>";
			// print_r($_POST);
			// echo "</pre>";
			$db->close();
			die;
		}
	?>
	<form action="#" method="POST">
		<h1>Genereer meme</h1>
		<label>Template:</label>
		<select name="template">
		<?php
		$res = $db->query("SELECT * FROM templates");
		$ids = array();
		$names = array();
		while($row = $res->fetch_assoc()) {
			if($row['skip'] == 1) continue;
			$id = $row['id'];
			$ids[] = $row['id'];
			// $url = $row['url'];
			$res2 = $db->query("SELECT naam FROM persons WHERE id=$id");
			$row = $res2->fetch_assoc();
			// echo $row['naam'];
			$names[] = $row['naam'];
			// echo "</option>";
		}
		array_multisort($names, $ids);
		for($i = 0; $i < count($names); $i++) {
			echo "<option value='$ids[$i]'>";
			echo $names[$i];
			echo "</option>";
		}
		$db->close();
		?>
		</select>
		<br />
		<label>Top caption:</label>
		<input type="text" name="top">
		<br />
		<label>Bottom caption:</label>
		<input type="text" name="bottom">
		<br />
		<input type="submit" value="Submit">
	</form>
	<br />
	<form action="memes.php" methode="GET">
		<p>Bekijk alle memes van:</p>
		<select name="id">
		<?php
			for($i = 0; $i < count($names); $i++) {
				echo "<option value='$ids[$i]'>";
				echo $names[$i];
				echo "</option>";
			}
		?>
		</select>
		<input type="submit" value="Bekijk">
	</form>
	<br />
	<br />
	<a href="template.php">Voeg een template toe</a><br />
    <a href="templates.php">Bekijk alle templates</a><br />
    <a href="meme.php?id=<?php echo $latest_id; ?>">Bekijk de laatste meme</a><br />
</body>
</html>
