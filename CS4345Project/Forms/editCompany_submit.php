<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	include '../Classes/Company.php';
	
	//print_r($_POST);
	//print_r($_FILES);
	/*** first check that both the username, password and form token have been sent 
	 * We will check the file upload in the update/insert logic of the Picture class
	 ****/
	if(!isset( $_POST['companyName'], $_POST['form_token']))
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
			updateCompany($_GET['id']);
		else
			insertCompany();
		
		$message = "Company edited sucessfully!";
	}
	
	if($_POST['isIndividual'] == 'true' && $_GET['action'] != 'update'){
		header("Location: ".WEB_ROOT."Forms/editPointOfContact.php?fromCompany=".$_POST['companyName']);
	
	}
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>