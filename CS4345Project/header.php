<?php
	if(!isset($_SESSION['user_id']) && $_SESSION['redirectToLogon'] != 1)
	{
		$_SESSION['redirectToLogon'] = 1;
		header("Location: Forms/login.php");
	}
	else
	{
		$message = "Welcome to our site";
	}
	ini_set('display_errors',1);  
	error_reporting(E_ALL);
	
	$cssIncludes = "<link rel='stylesheet' href='/CS4353Project/CS4345Project/css/main.css'>"

?>
<!DOCTYPE html>
<html>
	<head>
		<?php echo $cssIncludes;?>
		<title><?php echo $_SESSION['pageTitle'];?></title>
	</head>
	<header id='headerTop'>
		<div id='headerImage'><a href='/CS4353Project/CS4345Project/index.php'><img src='/CS4353Project/CS4345Project/images/logo.png' /></a>
		</div>
	</head>