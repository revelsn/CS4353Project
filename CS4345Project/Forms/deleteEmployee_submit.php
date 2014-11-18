<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Employee.php';
	//print_r($_POST);
	
	$sucess = deleteEmployee($_POST['id']);
	if($sucess == TRUE)	
		$message = "Employee deleted sucessfully!";
	else
		$message = "The Employee will not die!";
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>