<?php
	session_start();
	$_SESSION['pageTitle'] = 'Transaction';
	include_once '../header.php';
	include_once '../Classes/Transaction.php';
	include_once '../Classes/Employee.php';
	include_once '../Classes/PointOfContact.php';
	
	$whereClause = null;
	
	if(isset($_GET['employeeID']) && $_GET['employeeID'] != 'all'){
		$whereClause['employeeID'] = $_GET['employeeID'];
	}
	
	if(isset($_GET['pointOfContactId']) && $_GET['pointOfContactId'] != 'all'){
		$whereClause['pointOfContactId'] = $_GET['pointOfContactId'];
	}
	
	if(isset($_GET['followUpReq']) && $_GET['followUpReq'] =='true'){
		$whereClause['followUpReq'] = $_GET['followUpReq'];
	}
	
	if(isset($_GET['resultInSale']) && $_GET['resultInSale'] =='true'){
		$whereClause['resultInSale'] = $_GET['resultInSale'];
	}
	
	if(isset($_GET['type']) && $_GET['type'] !='all'){
		$whereClause['type'] = $_GET['type'];
	}
	
	
	$transactions = getAllTransactions($whereClause);
	$employees = getAllEmployees();
	$pocs = getAllPointsOfContact();
	//print_r($transactions);
?>
	<script>
	$(function() {
		$("#type").hide(); 
		$("#resultInSale").click(function() 
		{
			$("#type").toggle(); 
		});
	    	
	});
	</script>
	<body>
		<h2>Transaction</h2>
		<div class='form'>Filter by:
			<form action='showTransaction.php' method='get'>
				<fieldset> 
					<p> 
						<label for="employeeID">Employee</label>
						<select name="employeeID">
							<option value='all'>All</option>
						<?php 
							foreach($employees as $employee){
								if(isset($_GET['employeeID'])){
									if($_GET['employeeID'] == $employee['id'])
										$selected = 'selected';
									else
										$selected = '';
								}
								echo "<option value = '".$employee['id']."' ".$selected.">".str_replace("'", "", $employee['fName'])." ".str_replace("'", "", $employee['lName'])."</option>";
							}
						?>
						</select>
					</p> 
					
					<p> 
						<label for="pointOfContactId">Point Of Contact</label>
						<select name="pointOfContactId">
							<option value='all'>All</option>
							<?php 
								foreach($pocs as $poc){
									if(isset($_GET['pointOfContactId'])){
										if($_GET['pointOfContactId'] == $poc['id'])
											$selected = 'selected';
										else
											$selected = '';
									}
									echo "<option value = '".$poc['id']."' ".$selected.">".str_replace("'", "", $poc['fName'])." ".str_replace("'", "", $poc['lName'])."</option>";
								}
							?>
						</select>
					</p> 
					
					<p>
						<input type='checkbox' name='followUpReq' value='true'>Follow up requested</input>
						<input type='checkbox' name='resultInSale' value='true' id='resultInSale'>Resulted in Sale</input>
						<select name="type" id='type'>
							<option value='all'>--Select a Type--</option>
							<option value='B'>Bonds</option>
							<option value='S'>Stocks</option>
							<option value='F'>Fixed</option>
							<option value='C'>Cash</option>
						</select>
					</p>
					
				</fieldset>
				<p>
					<input type="submit" value="Submit" />
				</p> 
			</form>
		</div>
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
				if(count($transactions)){
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
				}
				else{
					echo "<tr><td colspan='";
					echo ($_SESSION['user_is_admin'] == 1 ? '9' : '8');
					echo "'>There are no results</td></tr>";
				}
			?>
			
		</table>
<?php 
	include '../footer.php';
?>
