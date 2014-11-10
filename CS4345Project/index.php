<?php
	session_start();
	$_SESSION['pageTitle'] = 'Index Page';
	include 'header.php';
?>
<body>
	<div>
		Welcome to the J.G. Wentworth Content Management System
	</div>
<?php 
	include 'footer.php';
?>