<?php
	if(file_exists("./config.php"))
		require("./config.php");
	else
		require("../config.php");
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
	
	$cssIncludes = "<link rel='stylesheet' href='".WEB_ROOT."css/main.css'>";
	
	$scriptIncludes = "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
			<script src='".WEB_ROOT."Scripts/mainScripts.js'></script>";

?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			echo $cssIncludes;
			echo $scriptIncludes;
		?>
		<title><?php echo $_SESSION['pageTitle'];?></title>
	</head>
	<header id='headerTop'>
		<div id='headerImage'><a href='<?php echo WEB_ROOT;?>index.php'><img src='<?php echo WEB_ROOT;?>images/logo.png' /></a></div>
		<div class="navigation">
	  		<ul class="nav">
	  			<li>
	  				<a href='<?php echo WEB_ROOT;?>index.php'>Home</a>
	  			</li>
	  			<li>
	  				<a href="#">Services</a>
	  				<ul>
	  					<li><a href="#">Consulting</a></li>
	  					<li><a href="#">Sales</a></li>
	  					<li><a href="#">Support</a></li>
	  				</ul>
	  			</li>
	  			<li>
	  				<a href="#">About Us</a>
	  				<ul>
	  					<li><a href="#">Company</a></li>
	  					<li><a href="#">Mission</a></li>
	  					<li><a href="#">Contact Information</a></li>
	  				</ul>
	  			</li>
	  		</ul>
	  	</div>
	</header>
	<div class='clear'>&nbsp;</div>