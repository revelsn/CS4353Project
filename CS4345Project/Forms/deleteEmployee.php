<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Employee.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['empId'])){
		$employee = getEmployeeByID($_GET['empId']);
		$employee = $employee[1];
	}
	
	
?>
	<body>
		<h2>Delete Employee</h2>
		<p>
			Are you sure you want to delete <?php echo str_replace("'", "", $employee['fName'])." ".str_replace("'", "", $employee['lName']);?>
			<form action="deleteEmployee_submit.php" method="post">
				<input type="hidden" name="id" value="<?php echo $_GET['empId'];?>">
				<input type="submit" value="Delete" />
			</form> 
		</p>
<?php 
	include '../footer.php';
?>