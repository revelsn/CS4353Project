<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Company.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['id'])){
		$company = getCompanyByID($_GET['id']);
		$company = $company[1];
		//print_r($company);
	}
	//$locations = getAllLocations();

?>
	<body>
		<h2>Edit Company</h2>
		<form action="editCompany_submit.php<?php if(isset($_GET['id'])) echo '?action=update&id='.$_GET['id'];?>" method="post">
			<fieldset> 
				<input type="hidden" id="dateCreated" name="dateCreated" value="<?php echo date ("Y-m-d H:i:s", time());?>" />
				<p>
					<label for="username">Company Name * (If individual, put their name)</label>
					<input type="text" id="companyName" name="companyName" value="<?php if(isset($company)) echo str_replace("'", "", $company['companyName']);?>" />
				</p>
				<p> 
					<label for="isIndividual">Is an individual</label>
					<select name="isIndividual" id='isIndividual'>
						<option value='false' <?php if(isset($company) && $company['isIndividual'] == FALSE) echo "selected";?>>No</option>
						<option value='true' <?php if(isset($company) && $company['isIndividual']) echo "selected";?>>Yes</option>
					</select>
				</p> 
				
				
				<p> 
					<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
					<input type="submit" value="Submit" />
				</p> 
			</fieldset>
		</form> 
<?php 
	include '../footer.php';
?>