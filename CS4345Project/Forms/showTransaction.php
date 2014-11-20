<?php
	session_start();
	$_SESSION['pageTitle'] = 'Transaction';
	include '../header.php';
	include '../Classes/Transaction.php';
	
	$transactions = getAllTransactions();
	
	//print_r($transactions);
?>
	<body>
		<h2>Transaction</h2>
		<div><a href='editTransaction.php'>Add an Transaction</a></div>
		<table>
			<thead>
				<tr><th>Employee</th><th>Point of Contact</th><th>Date</th><th>Follow Up Request</th><th>type</th>
				<th>Result In Sale</th><th>Follow Up Transaction</th><th>Edit</th>
				<?php
					if($_SESSION['user_is_admin'] == 1)
						echo "<th>Delete</th>";
				?>
				</tr>
			</thead>
			<?php
				$a = 0;
				foreach($trasaction as $tra){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".str_replace("'", "", $tra['employeeId'])." ".str_replace("'", "", $tra['pointOfContactId'])."</td>";
					echo "<td>".date("F j, Y", strtotime($tra['date']))."</td><td>".str_replace("'", "", $tra['followUpReq'])."</td><td>".str_replace("'", "", $tra['resultOfSale'])."</td><td>".str_replace("'", "", $tra['followUpTransId'])."</td>";
					echo "<td> <a href='editTransaction.php?traId=".$tra['id']."'>Edit</a></td>";
					if($_SESSION['user_is_admin'] == 1)
						echo "<td> <a href='deleteTranaction.php?traId=".$tra['id']."'>Delete</a></td></tr>";
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>
