<?php
	session_start();
	$_SESSION['pageTitle'] = 'Transaction';
	include '../header.php';
	include '../Classes/Transaction.php';
	
	$transactions = getAllTransactions();
	
	print_r($transactions);
?>
	<body>
		<h2>Transaction</h2>
		<div><a href='editTransaction.php'>Add an Transaction</a></div>
		<table class='full'>
			<thead>
				<tr><th>Employee</th><th>Point of Contact</th><th>Date</th><th>Follow Up Request</th>
				<th>Result In Sale</th><th>Type</th><th>Follow Up Transaction</th><th>View</th><th>Edit</th>
				<?php
					if($_SESSION['user_is_admin'] == 1)
						echo "<th>Delete</th>";
				?>
				</tr>
			</thead>
			<?php
				$a = 0;
				foreach($transactions as $tra){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".$tra['employee']."</td><td>".$tra['pointOfContact']."</td>";
					echo "<td>".date("F j, Y", strtotime($tra['date']))."</td>";
					if($tra['followUpReq'])
						echo "<td><img src='".WEB_ROOT."images/checkmark.png' class='smallImage'></td>";
					else
						echo "<td><img src='".WEB_ROOT."images/x.png' class='smallImage'></td>";
					
					if($tra['resultInSale'])
						echo "<td><img src='".WEB_ROOT."images/checkmark.png' class='smallImage'></td>";
					else
						echo "<td><img src='".WEB_ROOT."images/x.png' class='smallImage'></td>";
					if($tra['resultInSale'])
						switch($tra['type']){
							case 'S':
								echo "<td>Stocks</td>";
								break;
							case 'B':
								echo "<td>Bonds</td>";
								break;
							case 'F':
								echo "<td>Fixed</td>";
								break;
							case 'C':
								echo "<td>Cash</td>";
								break;
						}
					else
						echo "<td>Inquiry</td>";
					
					if($tra['followUpTransID'] > 0)
						echo "<td><a href='viewTransaction.php?traId=".$tra['followUpTransID']."'>View Followup</a></td>";
					else
						echo "<td>-</td>";
					
					
					echo "<td> <a href='viewTransaction.php?id=".$tra['id']."'>View</a></td>";
					echo "<td> <a href='editTransaction.php?id=".$tra['id']."'>Edit</a></td>";
					if($_SESSION['user_is_admin'] == 1)
						echo "<td> <a href='deleteTranaction.php?id=".$tra['id']."'>Delete</a></td></tr>";
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>
