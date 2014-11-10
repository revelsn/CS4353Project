<?php

	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include '../header.php';

	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
?>

<html>
	<head>
		<title>Add User</title>
	</head>
	
	<body>
		<h2>Add user</h2>
		<form action="adduser_submit.php" method="post">
			<fieldset>
			<p>
				<label for="username">Username</label>
				<input type="text" id="username" name="username" value=""/>
			</p>
			<p>
				<label for="password">Password</label>
				<input type="text" id="password" name="password" value="" />
			</p>
			<p>
				<label for="empID">Emp ID</label>
				<input type="text" id="empID" name="empID" value="" />
			</p>
			<p>
				<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
				<input type="submit" value="&rarr; Login" />
			</p>
			</fieldset>
		</form>
<?php 
	include '../footer.php';
?>