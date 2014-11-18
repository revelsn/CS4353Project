<?php
include "../db_conn.php";
include "../Classes/Picture.php";
if(isset($_GET['id'])) {
	$photo = getPictureByID($_GET['id']);
	
	header("Content-length: ".$photo['size']);
	header("Content-type: ".$photo['mime']);
	header("Content-Disposition: attachment; filename=".$photo['name']);
	echo $photo['fileData'];
}
?>