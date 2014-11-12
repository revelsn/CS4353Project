<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Employee.php';
	/*** first check that both the username, password and form token have been sent ***/
	if(!isset( $_POST['username'], $_POST['password'], $_POST['form_token']))
	{
		$message = 'Please enter a valid username and password';
	}
	/*** check the form token is valid ***/
	elseif( $_POST['form_token'] != $_SESSION['form_token'])
	{
		$message = 'Invalid form submission';
	}
	/*** check the username is the correct length ***/
	elseif (strlen( $_POST['username']) == 0)
	{
		$message = 'Incorrect Length for Username';
	}
	/*** check the password is the correct length ***/
	elseif (strlen( $_POST['password']) == 0)
	{
		$message = 'Incorrect Length for Password';
	}
	else
	{
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