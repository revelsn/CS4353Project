<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Transaction.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
?>
	<body>
		<h2>Edit Transaction</h2>
		<form action="editTransaction_submit.php<?php if(isset($_GET['traId'])) echo '?action=update&id='.$_GET['traId'];?>" method="post" enctype="multipart/form-data">
			<fieldset> 
				<p> 
					<label for="employeeID">Employee</label>
					<select name="employeeID">
					<?php 
						foreach($employees as $employee){
							if(isset($transaction)){
								if($transaction['employee'] == $employee['employeeName'])
									$selected = 'selected';
								else
									$selected = '';
							}
							echo "<option value = '".$employee['id']."' ".$selected.">".$employee['employeeName']."</option>";
						}
					?>
					</select>
				</p> 
				<input type="hidden" id="date" name="date" value="<?php echo date ("Y-m-d H:i:s", time());?>" />
				<p>
					<label for="username">First Name *</label>
					<input type="text" id="fName" name="fName" value="<?php if(isset($employee)) echo str_replace("'", "", $employee['fName']);?>" />
				</p>
				<p>
					<label for="username">Last Name *</label>
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
					<label for="photo">Photo</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input name="photo" type="file" id="photo">
					<?php 
						if(isset($photo)){
						//	echo "<a href='viewPhoto.php?id=".$photo['id']."' target='_blank'>View Current Photo</a> <a href='deletePhoto.php?id=".$photo['id']."'>Delete Current Photo</a>";
							echo "<img class='contactPhoto' src='viewPhoto.php?id=".$photo['id']."' />";
						}
					?>
					<div class='clear'>&nbsp;</div> 
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