<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Employee.php';
	
	$employee = getEmployeeByID($_GET['employeeID']);
?>
	<body>
		<h2>Edit Employee</h2>
		<form action="login_submit.php" method="post">
			<fieldset> 
				<p>
					<label for="username">First Name</label>
					<input type="text" id="username" name="username" value="<?php echo $employee->fname;?>" />
				<p> 
					<label for="password">Password</label>
					<input type="text" id="password" name="password" value="" />
				</p> 
				<p> 
					<input type="submit" value="→ Login" />
				</p> 
			</fieldset>
		</form> 
<?php 
	include '../footer.php';
?>