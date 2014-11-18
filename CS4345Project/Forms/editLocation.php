<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Location.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['locId'])){
		$location = getLocationByID($_GET['locId']);
		$location = $location[1];
	}
	
	
?>
	<body>
		<h2>Edit Location</h2>
		<form action="editLocation_submit.php<?php if(isset($_GET['locId'])) echo '?action=update&id='.$_GET['locId'];?>" method="post">
			<fieldset> 
				<p>
					<label for="locationName">Location Name</label>
					<input type="text" id="locationName" name="locationName" value="<?php if(isset($location)) echo str_replace("'", "", $location['locationName']);?>" />
				</p>
				<p>
					<label for="streetAddr1">Street Address Line 1</label>
					<input type="text" id="streetAddr1" name="streetAddr1" value="<?php if(isset($location)) echo str_replace("'", "", $location['streetAddr1']);?>" />
				</p>
				<p>
					<label for="streetAddr2">Street Address Line 2</label>
					<input type="text" id="streetAddr2" name="streetAddr2" value="<?php if(isset($location)) echo str_replace("'", "", $location['streetAddr2']);?>" />
				</p>
				<p>
					<label for="city">City</label>
					<input type="text" id="city" name="city" value="<?php if(isset($location)) echo str_replace("'", "", $location['city']);?>" />
				</p>
				<p>
					<label for="state">State (2 letters)</label>
					<input type="text" id="state" name="state" value="<?php if(isset($location)) echo str_replace("'", "", $location['state']);?>" />
				</p>
				<p>
					<label for="zip">Zip</label>
					<input type="text" id="zip" name="zip" value="<?php if(isset($location)) echo str_replace("'", "", $location['zip']);?>" />
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