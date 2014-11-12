<?php
session_start();
$_SESSION['pageTitle'] = 'Login';
include "../db_conn.php";
include '../header.php';

error_reporting(E_ALL);
/*** check if the users is already logged in ***/
if(isset( $_SESSION['user_id'] ))
{
	$message = 'Users is already logged in';
}
/*** check that both the username, password have been submitted ***/
if(!isset( $_POST['username'], $_POST['password']))
{
	$message = 'Please enter a valid username and password';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['username']) == 0)
{
	$message = 'Incorrect Username';
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

	
	try
	{
		/*** prepare the select statement ***/
		$stmt = $db->qeury("SELECT empID, psswdHash FROM authentication WHERE username = :username", PDO::FETCH_OBJ);

		/*** bind the parameters ***/
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);

		/*** execute the prepared statement ***/
		$stmt->execute();

		/*** check for a result ***/
		$result = $stmt->fetch();
		/*** if we have no result then fail boat ***/
		if( password_verify($password, $result['psswdHash']) == false)
		{
			$message = 'Login Failed';
		}
		/*** if we do have a result, all is well ***/
		else
		{
			/*** set the session user_id variable ***/
			$_SESSION['user_id'] = $result['empID'];

			/*** tell the user we are logged in ***/
			$message = 'You are now logged in';
		}


	}
	catch(Exception $e)
	{
		/*** if we are here, something has gone wrong with the database ***/
		print_r($e);
		$message = 'We are unable to process your request. Please try again later';
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
