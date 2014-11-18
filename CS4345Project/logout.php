<?php
	session_start();
	$_SESSION['user_id'] = null;
	$_SESSION['user_is_admin'] = null;
	session_destroy();
	header("Location: index.php");
?>