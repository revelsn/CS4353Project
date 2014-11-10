<?php
	/*** begin our session ***/
	session_start();
	$_SESSION['pageTitle'] = 'Add a user';
	include "../db_conn.php";
	include '../header.php';
	/*** first check that both the username, password and form token have been sent ***/
	if(!isset( $_POST['username'], $_POST['password'], $_POST['form_token']))
	{
		$message = 'Please enter a valid username and password';
	}
	/*** check the form token is valid ***/
	elseif( $_POST['form_token'] != $_SESSION['form_token'])
	{
		$message = 'Invalid form submission';
	}
	/*** check the username is the correct length ***/
	elseif (strlen( $_POST['username']) == 0)
	{
		$message = 'Incorrect Length for Username';
	}
	/*** check the password is the correct length ***/
	elseif (strlen( $_POST['password']) == 0)
	{
		$message = 'Incorrect Length for Password';
	}
	else
	{
		/*** if we are here the data is valid and we can insert it into database ***/
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		$empID = filter_var($_POST['$empID'], FILTER_SANITIZE_STRING);
	
		/*** now we can encrypt the password ***/
		$passwdHash = password_hash($password, PASSWORD_DEFAULT);
	
		
	
		try
		{
			/*** prepare the insert ***/
			$stmt = $db->prepare("INSERT INTO authentication (userName, psswdHash, empID ) VALUES (:username, :password, :empID )");
	
			/*** bind the parameters ***/
			$stmt->bindParam(':phpro_username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $passwdHash, PDO::PARAM_STR);
			$stmt->bindParam(':empID', $empID, PDO::PARAM_STR);
	
			/*** execute the prepared statement ***/
			$stmt->execute();
	
			/*** unset the form token session variable ***/
			unset( $_SESSION['form_token'] );
	
			/*** if all is done, say thanks ***/
			$message = 'New user added';
		}
		catch(Exception $e)
		{
			/*** check if the username already exists ***/
			if( $e->getCode() == 23000)
			{
				$message = 'Username already exists';
			}
			else
			{
				/*** if we are here, something has gone wrong with the database ***/
				$message = 'We are unable to process your request. Please try again later"';
			}
		}
		$db = null;
	}
?>
<body>
	<p><?php echo $message; ?><br />
		<a href='../index.php'>Go back to home page</a>
	</p>
<?php 
	include '../footer.php';
?>