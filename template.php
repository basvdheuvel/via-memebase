<?php
    include 'config.php';
?>
<html>
<body>
<style>
	.sucess{
	color:#088A08;
	}
	.error{
	color:red;
	}
</style>
<?php
if(isset($_POST['top'])) {
	$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
	$upload_exts = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
	if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2000000) && in_array($upload_exts, $file_exts)) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else {
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			// echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			$name = $_FILES["file"]["name"];
			// Enter your path to upload file here
			while (file_exists("templates/" . $name)) {
				$name = md5($name) . '.' . $upload_exts;
			}

			if(trim(strip_tags($db->real_escape_string($_POST['top']))) == "") die;
			$naam = trim(strip_tags($db->real_escape_string($_POST['top'])));
			$db->query("INSERT INTO persons (naam) VALUES ('$naam');");
			$id = $db->insert_id;
			$db->query("INSERT INTO templates (person, url) VALUES ('$id', '$name');");
			move_uploaded_file($_FILES["file"]["tmp_name"], "templates/" . $name);
			// echo "<div class='sucess'>"."Stored in: " . "templates/" . $name."</div>";
			echo "<div class='sucess'>Template opgeslagen.</div>";
		}
	}
	else
	{
		echo "<div class='error'>Invalid file</div>";
	}
}
else {
?>
<form action="#" method="post" enctype="multipart/form-data">
	<h1>Upload template</h1>
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br />
<label>Naam</label>
<input type="text" name="top">
<input type="submit" name="submit" value="Submit">
</form>
<?php } ?>
</body>
</html>
