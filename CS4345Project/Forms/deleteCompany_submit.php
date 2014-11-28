<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Delete a Company';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Company.php';
	//print_r($_POST);
	
	$sucess = deleteCompany($_POST['id']);
	if($sucess == TRUE)	
		$message = "Company deleted sucessfully!";
	else
		$message = "The company will not die!";
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>