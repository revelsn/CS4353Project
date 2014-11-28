<?php
	session_start();
	$_SESSION['pageTitle'] = 'Delete a Company';
	include '../header.php';
	include '../Classes/Company.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['id'])){
		$company = getCompanyByID($_GET['id']);
		$company = $company[1];
	}
	//print_r($company);
	
?>
	<body>
		<h2>Delete Company</h2>
		<p>
			Are you sure you want to delete <?php echo str_replace("'", "", $company['companyName']);?>
			<form action="deleteCompany_submit.php" method="post">
				<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
				<input type="submit" value="Delete" />
			</form> 
		</p>
<?php 
	include '../footer.php';
?>