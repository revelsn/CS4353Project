<?php
	session_start();
	$_SESSION['pageTitle'] = 'Login';
	include '../header.php';
	include '../Classes/Transaction.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	
	if(isset($_GET['empId'])){
		$transaction = getTransactionByID($_GET['empId']);
		$transaction = $transaction[1];
	}
	
	
?>
	<body>
		<h2>Delete Transaction</h2>
		<p>
			Are you sure you want to delete <?php echo str_replace("'", "", $transaction['date']).
			" ".str_replace("'", "", $transaction['followUpReq'])." ".str_replace("'", "", $transaction['type']).
			" ".str_replace("'", "", $transaction['resultInSale']);?>
			<form action="deleteTransaction_submit.php" method="post">
				<input type="hidden" name="id" value="<?php echo $_GET['traId'];?>">
				<input type="submit" value="Delete" />
			</form> 
		</p>
<?php 
	include '../footer.php';
?>
