<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Employee.php';
	
?>
	<body>
		<h2>Login Here</h2>
		<form action="login_submit.php" method="post">
			<fieldset> 
				<p>
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" />
				<p> 
					<label for="password">Password</label>
					<input type="password" id="password" name="password" value="" />
				</p> 
				<p> 
					<input type="submit" value="Login" />
				</p> 
			</fieldset>
		</form> 
<?php 
	include '../footer.php';
?>