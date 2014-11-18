<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Location.php';
	
	print_r($_POST);
	/*** first check that both the username, password and form token have been sent ***/
	if(!isset( $_POST['locationName'], $_POST['city'], $_POST['form_token']))
	{
		$message = 'Please enter a valid location name and city';
	}
	/*** check the form token is valid ***/
	elseif( $_POST['form_token'] != $_SESSION['form_token'])
	{
		$message = 'Invalid form submission';
	}
	else
	{
		if(isset($_GET['action']) && $_GET['action'] == 'update')
			updateLocation($_GET['id']);
		else
			insertLocation();
		
		$message = "Location edited sucessfully!";
	}
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>