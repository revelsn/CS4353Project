<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Transaction.php';
	//print_r($_POST);
	
	$sucess = deleteTransaction($_POST['id']);
	if($sucess == TRUE)	
		$message = "Transaction deleted sucessfully!";
	else
		$message = "The Transaction will not die!";
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>