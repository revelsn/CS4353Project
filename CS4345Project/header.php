<?php
	print_r($_SESSION);
	if(!isset($_SESSION['user_id']))
	{
		$message = "log in";
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