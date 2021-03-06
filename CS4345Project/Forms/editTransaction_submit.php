<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Transaction.php';
	
	//print_r($_POST);
	//print_r($_FILES);
	/*** first check that both the username, password and form token have been sent 
	 * We will check the file upload in the update/insert logic of the Picture class
	 ****/
	if(!isset( $_POST['employeeID'], $_POST['pointOfContactId'], $_POST['date'], $_POST['followUpReq'], $_POST['type'],
			 $_POST['resultInSale'], $_POST['form_token']))
	{
		$message = 'Please enter a valid Name and Location';
	}
	/*** check the form token is valid ***/
	elseif( $_POST['form_token'] != $_SESSION['form_token'])
	{
		$message = 'Invalid form submission';
	}
	else
	{
		if(isset($_GET['action']) && $_GET['action'] == 'update')
			updateTransaction($_GET['id']);
		else
			insertTransaction();
		
		$message = "Transaction edited sucessfully!";
	}
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>