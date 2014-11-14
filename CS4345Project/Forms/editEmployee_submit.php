<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Employee.php';
	
	print_r($_POST);
	/*** first check that both the username, password and form token have been sent ***/
	if(!isset( $_POST['fName'], $_POST['lName'], $_POST['locationID'], $_POST['form_token']))
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
			updateEmployee($_GET['id']);
		else
			insertEmployee();
	}
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>