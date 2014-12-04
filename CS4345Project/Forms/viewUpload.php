<?php
include_once "../db_conn.php";
include_once "../Classes/Upload.php";
if(isset($_GET['id'])) {
	$upload = getUploadByID($_GET['id']);

	header("Content-length: ".$upload['size']);
	header("Content-type: ".$upload['mime']);
	header("Content-Disposition: attachment; filename=".$upload['name']);
	echo $upload['fileData'];
}
?>