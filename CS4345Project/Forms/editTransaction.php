<?php
	session_start();
	$_SESSION['pageTitle'] = 'Edit a transaction';
	include '../header.php';
	include '../Classes/Transaction.php';
	
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	if(isset($_GET['id'])){
		$transaction = getTransactionByID($_GET['id']);
		$transaction = $transaction[1];
		//$uploads = getUploadsByTransID($_GET['id']);
		
	}
	print_r($transaction);
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
	$employees = getAllEmployees();
	$pocs = getAllPointsOfContact();
	$transactions = getAllTransactions();
?>
	<body>
		<script>
		function checkSale(){
			var list = document.getElementById('resultInSale');
			if(list[list.selectedIndex].value == 'false'){
				document.getElementById('type').style.display = 'none';
			}
			else{
				document.getElementById('type').style.display = 'block';
			}
		}
		function checkFollowUpTransaction(){
			var list = document.getElementById('followUpTrans');
			if(list[list.selectedIndex].value == 'false'){
				document.getElementById('previousTransactionID').style.display = 'none';
			}
			else{
				document.getElementById('previousTransactionID').style.display = 'block';
			}
		}
		</script>
		<h2>Edit Transaction<?php if(isset($_GET['id'])) echo '- Trans. ID = '.$_GET['id'];?></h2>
		<form action="editTransaction_submit.php<?php if(isset($_GET['id'])) echo '?action=update&id='.$_GET['id'];?>" method="post" enctype="multipart/form-data">
			<fieldset> 
				<p> 
					<label for="employeeID">Employee</label>
					<select name="employeeID">
					<?php 
						foreach($employees as $employee){
							if(isset($transaction)){
								if($transaction['employeeId'] == $employee['id'])
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
					<label for="pointOfContactId">Point of Contact</label>
					<select name="pointOfContactId">
					<?php 
						foreach($pocs as $poc){
							if(isset($transaction)){
								if($transaction['pointOfContactId'] == $poc['id'])
									$selected = 'selected';
								else
									$selected = '';
							}
							echo "<option value = '".$poc['id']."' ".$selected.">".str_replace("'", "", $poc['fName'])." ".str_replace("'", "", $poc['lName'])."</option>";
						}
					?>
					</select>
				</p> 
				<input type="hidden" id="date" name="date" value="<?php echo date ("Y-m-d H:i:s", time());?>" />
				<p> 
					<label for="followUpReq">Is follow up required?</label>
					<select name="followUpReq" id='followUpReq'>
						<option value='false' <?php if(isset($transaction) && $transaction['followUpReq'] == FALSE) echo "selected";?>>No</option>
						<option value='true' <?php if(isset($transaction) && $transaction['followUpReq']) echo "selected";?>>Yes</option>
					</select>
				</p>
				<p> 
					<label for="resultInSale">Result in Sale?</label>
					<select name="resultInSale" id='resultInSale' onchange='checkSale()' onclick='checkSale()' onblur='checkSale()'>
						<option value='false' <?php if(isset($transaction) && $transaction['resultInSale'] == FALSE) echo "selected";?>>No</option>
						<option value='true' <?php if(isset($transaction) && $transaction['resultInSale']) echo "selected";?>>Yes</option>
					</select>
				</p> 
				<p id='type' style='display:none;'> 
					<label for="type">Type of transaction?</label>
					<select name="type">
						<option value='S' <?php if(isset($transaction) && $transaction['type'] == 'S') echo "selected";?>>Stocks</option>
						<option value='B' <?php if(isset($transaction) && $transaction['type'] == 'B') echo "selected";?>>Bonds</option>
						<option value='F' <?php if(isset($transaction) && $transaction['type'] == 'F') echo "selected";?>>Fixed</option>
						<option value='C' <?php if(isset($transaction) && $transaction['type'] == 'C') echo "selected";?>>Cash</option>
					</select>
				</p>
				<p> 
					<label for="notes">Notes</label>
					<textarea rows="4" cols="50" name='notes'></textarea>
				</p>  
				
				<p> 
					<label for="followUpTrans">Is this a follow up?</label>
					<select name="followUpTrans" id='followUpTrans' onchange='checkFollowUpTransaction()' onclick='checkFollowUpTransaction()' onblur='checkFollowUpTransaction()'>
						<option value='false'>No</option>
						<option value='true'>Yes</option>
					</select>
				</p>
				<p id='previousTransactionID' style='display:none;'> 
					<label for="previousTransactionID">Please select the previous Trans. ID #</label>
					<select name="previousTransactionID">
					<?php 
						foreach($transactions as $trans){
							if(isset($transaction)){
								if($transaction['followUpTransID'] == $trans['id'])
									$selected = 'selected';
								else
									$selected = '';
							}
							echo "<option value = '".$trans['id']."' ".$selected.">".$trans['id']."</option>";
						}
					?>
					</select>
				</p>
				<p>
					<label for="upload">Files</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input name="upload" type="file" id="photo">
					<?php 
						if(isset($uploads)){
							foreach($uploads as $upload)
								echo "<a href='viewUpload.php?id=".$upload['id']."' />";
						}
					?>
					<div class='clear'>&nbsp;</div> 
				</p>
				<p> 
					<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
					<input type="submit" value="Submit" />
				</p> 
			</fieldset>
		</form> 
<?php 
	include '../footer.php';
?>