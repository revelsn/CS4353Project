<?php
	if(file_exists("./config.php"))
		require("./config.php");
	else
		require("../config.php");
	if(!isset($_SESSION['user_id']) && !stristr($_SERVER["PHP_SELF"], 'login'))
	{
		header("Location: ".WEB_ROOT."Forms/login.php");
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
		<?php
			if(isset($_GET['makeItRain']) && $_GET['makeItRain'] > 0){
				echo "<div id='headerImageLeft'><img src='".WEB_ROOT."images/1.gif' /></div>";
			}
		?>
		<div id='headerImage'><a href='<?php echo WEB_ROOT;?>index.php'><img src='<?php echo WEB_ROOT;?>images/logo.png' /></a></div>
		<?php
			if(isset($_GET['makeItRain']) && $_GET['makeItRain'] > 0){
				echo "<div id='headerImageRight'><img src='".WEB_ROOT."images/2.gif' /></div>";
			}
		?>
		<div class="navigation">
	  		<ul class="nav">
	  			<li>
	  				<a href='<?php echo WEB_ROOT;?>index.php'>Home</a>
	  			</li>
	  			<li>
	  				<a href="#">Employees</a>
	  				<ul>
	  					<li><a href="/Forms/showEmployees.php">Employee List</a></li>
	  					<li><a href="/Forms/editEmployee.php">Add Employee</a></li>
	  				</ul>
	  			</li>
	  			<li>
	  				<a href="#">Locations</a>
	  				<ul>
	  					<li><a href="/Forms/showLocations.php">Location List</a></li>
	  					<li><a href="/Forms/editLocation.php">Add Location</a></li>
	  				</ul>
	  			</li>
	  			<li>
	  				<a href="<?php echo WEB_ROOT?>logout.php">Logout</a>
	  			</li>
	  		</ul>
	  	</div>
	</header>
	<div class='clear'>&nbsp;</div>