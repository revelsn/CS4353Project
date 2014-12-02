<?php
	session_start();
	$_SESSION['pageTitle'] = 'Transaction';
	include '../header.php';
	include '../Classes/Transaction.php';
	
	$transaction = getTransactionByID($_GET['id'])[1];
	
	//print_r($transaction);
?>
	<body>
		<h2>Transaction</h2>
		<?php
			echo "<div class='transactionItem'><span class='label'>Transaction ID: </span>".$transaction['id']."</div>";
			echo "<div class='transactionItem'><span class='label'>Employee: </span>".$transaction['employee']."</div>";
			echo "<div class='transactionItem'><span class='label'>Point of Contact: </span>".$transaction['pointOfContact']."</div>";
			echo "<div class='transactionItem'><span class='label'>Date: </span>".$transaction['date']."</div>";
			if($transaction['resultInSale']){
				echo "<div class='transactionItem'><span class='label'>Resulted in Sale: </span>Yes</div>";
				echo "<div class='transactionItem'><span class='label'>Type: </span>";
				switch($transaction['type']){
					case 'S':
						echo "Stocks</div>";
						break;
					case 'B':
						echo "<td>Bonds</div>";
						break;
					case 'F':
						echo "<td>Fixed</div>";
						break;
					case 'C':
						echo "<td>Cash</div>";
						break;
				}
			}
			else
				echo "<div class='transactionItem'><span class='label'>Type: </span>Inquiry</div>";
			if($transaction['followUpReq'])
				echo "<div class='transactionItem'><span class='label'>Follow up required: </span>Yes</div>";
			else
				echo "<div class='transactionItem'><span class='label'>Follow up required: </span>No</div>";
			if($transaction['followUpTransID'] > 0)
				echo "<div class='transactionItem'><span class='label'>Follow up transaction: </span><a href='viewTransaction.php?id=".$transaction['followUpTransID']."'>View</a></div>";
			if($transaction['previousTransactionID'] > 0)
				echo "<div class='transactionItem'><span class='label'>Previous transaction: </span><a href='viewTransaction.php?id=".$transaction['previousTransactionID']."'>View</a></div>";
	include '../footer.php';
?>
