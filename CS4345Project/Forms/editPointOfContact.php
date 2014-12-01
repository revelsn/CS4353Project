<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/PointOfContact.php';
	include '../Classes/Company.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['id'])){
		$poc = getPocByID($_GET['id']);
		$poc = $poc[1];
		$photo = getPictureByPOCID($_GET['id']);
		//print_r($photo);
	}
	$companies = getAllCompanies();
	
	if(isset($_GET['fromCompany'])){
		$message = 'You have created an company specified as an individual. <br />Please enter their information here:';
		$poc['companyName'] = $_GET['fromCompany'];
		$poc['fName'] = $poc['lName'] = $poc['email'] = $poc['phone'] = '';
		
	}
?>
	<body>
		<h2><?php if(isset($_GET['fromCompany'])) echo $message; else echo 'Edit Point Of Contact';?></h2>
		<form action="editPointOfContact_submit.php<?php if(isset($_GET['id'])) echo '?action=update&id='.$_GET['id'];?>" method="post" enctype="multipart/form-data">
			<fieldset> 
				<input type="hidden" id="date" name="date" value="<?php echo date ("Y-m-d H:i:s", time());?>" />
				<p>
					<label for="fname">First Name *</label>
					<input type="text" id="fName" name="fName" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['fName']);?>" />
				</p>
				<p>
					<label for="lName">Last Name *</label>
					<input type="text" id="lName" name="lName" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['lName']);?>" />
				</p>
				<p>
					<label for="email">Email *</label>
					<input type="text" id="email" name="email" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['email']);?>" />
				</p>
				<p>
					<label for="phone">Phone *</label>
					<input type="text" id="phone" name="phone" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['phone']);?>" />
				</p>
				<p> 
					<label for="companyID">Company</label>
					<select name="companyID">
					<?php 
						foreach($companies as $company){
							if(isset($company)){
								if($company['companyName'] == $poc['companyName'])
									$selected = 'selected';
								else
									$selected = '';
							}
							echo "<option value = '".$company['id']."' ".$selected.">".str_replace("'", "", $company['companyName'])."</option>";
						}
					?>
					</select>
				</p> 
				<p>
					<label for="photo">Photo</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input name="photo" type="file" id="photo">
					<?php 
						if(isset($photo['id'])){
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
