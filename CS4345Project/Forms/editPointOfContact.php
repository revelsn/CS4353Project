<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/PointOfContact.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['compId'])){
		$poc = getPointOfContactByID($_GET['compId']);
		$poc = $poc[1];
		$photo = getPictureByPOCID($_GET['compId']);
		//print_r($photo);
	}
	
?>
	<body>
		<h2>Edit Point Of Contact</h2>
		<form action="editPointOfContact_submit.php<?php if(isset($_GET['compId'])) echo '?action=update&id='.$_GET['compId'];?>" method="post" enctype="multipart/form-data">
			<fieldset> 
				<input type="hidden" id="date" name="date" value="<?php echo date ("Y-m-d H:i:s", time());?>" />
				<p>
					<label for="username">First Name *</label>
					<input type="text" id="fName" name="fName" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['fName']);?>" />
				</p>
				<p>
					<label for="username">Last Name *</label>
					<input type="text" id="lName" name="lName" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['lName']);?>" />
				</p>
				<p>
					<label for="username">Email *</label>
					<input type="text" id="email" name="email" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['email']);?>" />
				</p>
				<p>
					<label for="username">Phone *</label>
					<input type="text" id="phone" name="phone" value="<?php if(isset($poc)) echo str_replace("'", "", $poc['phone']);?>" />
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
