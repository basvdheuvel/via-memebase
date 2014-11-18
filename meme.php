<?php
include 'config.php';
header('Content-Type: image/png');

if(!isset($_GET['id'])) die;

$max_size = 50;

$id = $db->real_escape_string($_GET['id']);
$res = $db->query("SELECT * FROM memes WHERE id=$id");
if($res->num_rows == 0) die;
$row = $res->fetch_assoc();
$template = $row['template'];
$tmp = $db->query("SELECT url FROM templates WHERE id=$template")->fetch_assoc();
$url = htmlentities($tmp['url']);

$top = strtoupper($row['top']);
$bottom = strtoupper($row['bottom']);

$ext = pathinfo("templates/$url", PATHINFO_EXTENSION);

if($ext == "jpg" || $ext == "jpeg") {
	$img = imagecreatefromjpeg("templates/$url");
}
else if($ext == "png") {
	$img = imagecreatefrompng("templates/$url");
}
else {
	die;
}

$w = imagesx($img);
$h = imagesy($img);

$black = imagecolorallocate($img, 0, 0, 0);
$white = imagecolorallocate($img, 255, 255, 255);

$size = $max_size;
while(1) {
	$tsize = imagettfbbox($size, 0.0, "./impact.ttf", $top);
	if(abs($tsize[0]) + abs($tsize[2]) < $w - 10) {
		break;
	}
	$size--;
}
$tsize = imagettfbbox($size, 0, "./impact.ttf", $top);
$xsize = abs($tsize[0]) + abs($tsize[2]);
$ysize = abs($tsize[5]) + abs($tsize[1]);
$sleft = round(($w - 10 - $xsize) / 2);
for($i = -1; $i < 2; $i++) {
	for($j = -1; $j < 2; $j++) {
		imagettftext($img, $size, 0.0, 5+$i+$sleft, 5+$j+$ysize, $black, "./impact.ttf", $top);
	}
}
imagettftext($img, $size, 0.0, 5+$sleft, 5+$ysize, $white, "./impact.ttf", $top);

$size = $max_size;
while(1) {
	$tsize = imagettfbbox($size, 0.0, "./impact.ttf", $bottom);
	if(abs($tsize[0]) + abs($tsize[2]) < $w - 10) {
		break;
	}
	$size--;
}
$tsize = imagettfbbox($size, 0, "./impact.ttf", $bottom);
$xsize = abs($tsize[0]) + abs($tsize[2]);
$ysize = abs($tsize[5]) + abs($tsize[1]);
$sleft = round(($w - 10 - $xsize) / 2);
for($i = -1; $i < 2; $i++) {
	for($j = -1; $j < 2; $j++) {
		imagettftext($img, $size, 0.0, 5+$i+$sleft, $h-5+$j, $black, "./impact.ttf", $bottom);
	}
}
imagettftext($img, $size, 0.0, 5+$sleft, $h-5, $white, "./impact.ttf", $bottom);
$db->close();
imagepng($img);
imagedestroy($img);
?>
