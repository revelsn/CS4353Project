<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Employee.php';
	include '../Classes/Location.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['empId'])){
		$employee = getEmployeeByID($_GET['empId']);
		$employee = $employee[1];
	}
	$locations = getAllLocations();
	
?>
	<body>
		<h2>Edit Employee</h2>
		<form action="editEmployee_submit.php<?php if(isset($_GET['empId'])) echo '?action=update&id='.$_GET['empId'];?>" method="post">
			<fieldset> 
				<input type="hidden" id="date" name="date" value="<?php echo date ("Y-m-d H:i:s", time());?>" />
				<p>
					<label for="username">First Name</label>
					<input type="text" id="fName" name="fName" value="<?php if(isset($employee)) echo str_replace("'", "", $employee['fName']);?>" />
				</p>
				<p>
					<label for="username">Last Name</label>
					<input type="text" id="lName" name="lName" value="<?php if(isset($employee)) echo str_replace("'", "", $employee['lName']);?>" />
				</p>
				<p> 
					<label for="locationID">Location</label>
					<select name="locationID">
					<?php 
						foreach($locations as $location){
							if(isset($employee)){
								if($employee['location'] == $location['locationName'])
									$selected = 'selected';
								else
									$selected = '';
							}
							echo "<option value = '".$location['id']."' ".$selected.">".$location['locationName']."</option>";
						}
					?>
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