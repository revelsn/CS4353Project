<?php
	session_start();
	if(!isset($_SESSION['user_id']))
	{
		header("Location: login.php");
		die();
	}
	else
	{
		$message = "Welcome to our site";
	}

?>
<!DOCTYPE html>
<html>
	<?php 
		echo $message;
	?>
</html>