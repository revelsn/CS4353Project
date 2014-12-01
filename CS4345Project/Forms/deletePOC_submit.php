<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Delete a POC';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/PointOfContact.php';
	//print_r($_POST);
	
	$sucess = deletePointOfContact($_POST['id']);
	if($sucess == TRUE)	
		$message = "POC deleted sucessfully!";
	else
		$message = "The POC will not die!";
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>