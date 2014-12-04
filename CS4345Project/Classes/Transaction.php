<?php
include '../db_conn.php';
include_once '../Classes/Employee.php';
include_once '../Classes/PointOfContact.php';
include_once '../Classes/Upload.php';
class Transaction{

	public $id;
	public $employeeId;
	public $pointOfContactId;
	public $date;
	public $followUpReq;
	public $type;
	public $resultInSale;
	public $notes;
	public $previousTransactionID;

	function __construct($employeeId, $pointOfContactId, $date, $followUpReq = false, $type = null, $resultInSale = false, $notes = '', $previousTransactionID = null){
		$this->setEmployeeId($employeeId);
		$this->setPointOfContactId($pointOfContactId);
		$this->setDate($date);
		$this->setFollowUpReq($followUpReq);
		$this->setType($type);
		$this->setResultInSale($resultInSale);
		$this->setNotes($notes);
		$this->setPreviousTransactionID($previousTransactionID);
	}

	function setID($id){
		$this->id = $id;
	}

	function setEmployeeId($employeeId){
		$this->employeeId = $employeeId;
	}

	function setPointOfContactId($pointOfContactId){
		$this->pointOfContactId = $pointOfContactId;
	}

	function setDate($date){
		$this->date = $date;
	}
	
	function setNotes($note){
		$this->notes = $note;
	}

	function setFollowUpReq($followUpReq){
		$this->followUpReq = $followUpReq;
	}
	
	function setType($type){
		$this->type = $type;
	}
	
	function setResultInSale($resultInSale){
		$this->resultInSale = $resultInSale;
	}
	
	function setPreviousTransactionID($previousTransactionID){
		$this->previousTransactionID = $previousTransactionID;
	}

	function getID(){
		return $this->id;
	}

	function getEmployeeId(){
		return $this->employeeId;
	}

	function getPointOfContactId(){
		return $this->pointOfContactId;
	}

	function getDate(){
		return $this->date;
	}

	function getFollowUpReq(){
		return $this->followUpReq;
	}
	
	function getType(){
		return $this->type;
	}
	
	function getResultInSale(){
		return $this->resultInSale;
	}
	
	function getNotes(){
		return $this->notes;
	}
	
	function getPreviousTransactionID(){
		return $this->previousTransactionID;
	}


	function saveTransaction(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO TRANSACTION (employeeId, pointOfContactId, date, followUpReq, type, notes, resultInSale, previousTransactionID) VALUES (:employeeId, :pointOfContactId, :date, :followUpReq, :type, :notes, :resultInSale, :previousTransactionID)");
			$employeeID = $this->getEmployeeId();
			$stmt->bindParam(':employeeId', $employeeID, PDO::PARAM_INT);
			$pointOfContactId = $this->getPointOfContactId();
			$stmt->bindParam(':pointOfContactId', $pointOfContactId, PDO::PARAM_INT);
			$date = $this->getDate();
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$followUpReq = $this->getFollowUpReq();
			$stmt->bindParam(':followUpReq', $followUpReq, PDO::PARAM_INT);
			$type = $this->getType();
			$stmt->bindParam(':type', $type, PDO::PARAM_STR);
			$notes = $this->getNotes();
			$stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
		    $resultInSale = $this->getResultInSale();
		    $stmt->bindParam(':resultInSale', $resultInSale, PDO::PARAM_INT);
		    $previousTransactionID = $this->getPreviousTransactionID();
		    $stmt->bindParam(':previousTransactionID', $previousTransactionID, PDO::PARAM_INT);
			$stmt->execute();
			
			
			if($this->getPreviousTransactionID() != null){
				//If we get here, we need to pull the transaction with the id of $this->getFollowUpTransId
				// and put the id of the transaction we just inserted into its followUpTransId field.
					
				$stmt = $db->prepare('SELECT * FROM TRANSACTION WHERE employeeId = :employeeId AND pointOfContactId = :pointOfContactId AND date = :date');
				$employeeID = $this->getEmployeeId();
				$stmt->bindParam(':employeeId', $employeeID, PDO::PARAM_INT);
				$pointOfContactId = $this->getPointOfContactId();
				$stmt->bindParam(':pointOfContactId', $pointOfContactId, PDO::PARAM_INT);
				$date = $this->getDate();
				$stmt->bindParam(':date', $date, PDO::PARAM_STR);
				$followUpReq = $this->getFollowUpReq();
				$stmt->execute();
				$currentTrans = $stmt->fetch(PDO::FETCH_ASSOC);
				//print_r($currentTrans);
				$stmt = $db->prepare("UPDATE TRANSACTION SET followUpTransId = :followUpTransId WHERE id = :id");
				$transToEdit = $this->getPreviousTransactionID();
				$stmt->bindParam(':id', $transToEdit, PDO::PARAM_INT);
				$stmt->bindParam(':followUpTransId', $currentTrans['id'], PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}

	function updateTransaction($id, $employeeID, $pointOfContactId, $date, $followUpReq, $type, $resultInSale, $followUpTransId, $previousTransactionID){
		global $db;
		try{
			if(isset($_FILES['upload']['name']) && $_FILES['upload']['size'] > 0)
				insertUpload($id, $_POST['fileDescription']);
			$stmt = $db->prepare("UPDATE TRANSACTION SET employeeId = :employeeId, pointOfContactId = :pointOfContactId, date = :date, followUpReq = :followUpReq,
					type = :type, resultInSale = :resultInSale, followUpTransId = :followUpTransId, previousTransactionID = :previousTransactionID  WHERE id = :id");
			$stmt->bindParam(':employeeId', $employeeID, PDO::PARAM_STR);
			$stmt->bindParam(':pointOfContactId', $pointOfContactId, PDO::PARAM_STR);
			$date = $db->quote($date);
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$followUpReq = $db->quote($followUpReq);
			$stmt->bindParam(':followUpReq', $followUpReq, PDO::PARAM_STR);
			$stmt->bindParam(':type', $type, PDO::PARAM_STR);
			$resultInSale = $db->quote($resultInSale);
			$stmt->bindParam(':resultInSale', $resultInSale, PDO::PARAM_STR);
			$stmt->bindParam(':followUpTransId', $followUpTransId, PDO::PARAM_STR);
			$stmt->bindParam(':previousTransactionID', $previousTransactionID, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo '<br>'.$e;
		}
		
	}
	
	function transactionArrayToObject($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM TRANSACTION WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$tra = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->date = $tra['date'];
		$this->followUpReq = $tra['followUpReq'];
		$this->type = $tra['type'];
		$this->resultInSale = $tra['resultInSale'];
		return $this;
	}
}

function getTransactionByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM TRANSACTION WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$tra = $stmt->fetch(PDO::FETCH_ASSOC);
	$emp = getEmployeeByID($tra['employeeId'])[1];
	$poc = getPocByID($tra['pointOfContactId'])[1];
	//print_r($poc);
	$tra['employee'] = str_replace("'", "", $emp['fName'])." ".str_replace("'", "", $emp['lName']);
	$tra['pointOfContact'] = str_replace("'", "", $poc['fName'])." ".str_replace("'", "", $poc['lName']);
	//We will wrap in in an array so we can use the foreach on the showTransaction page
	$tempArray['1'] = $tra;
	return $tempArray;
}


function insertTransaction(){
	if($_POST['resultInSale'] == 'true'){
		$resultInSale = 1;
		$type = $_POST['type'];
	}
	else{
		$resultInSale = 0;
		$type = null;
	}
	
	if($_POST['followUpTrans'] == false)
		$previousTransactionID = null;
	else{
		if(isset($_POST['previousTransactionID']) && $_POST['previousTransactionID'] > 0)
			$previousTransactionID = $_POST['previousTransactionID'];
		else
			$previousTransactionID = null;
	}
	
	if($_POST['followUpReq'] == 'true')
		$followUpReq = 1;
	else
		$followUpReq = 0;
	
	$tra = new Transaction($_POST['employeeID'], $_POST['pointOfContactId'], date('Y-m-d H:i:s',time()),
	$followUpReq, $type, $resultInSale, $_POST['notes'], $previousTransactionID);
	//print_r($tra);
	$tra->saveTransaction();
}

function updateTransaction($id){
	$tra = new Transaction('', '', '', '','','','','' );
	$tra->transactionArrayToObject($id);
	if($_POST['resultInSale'] == 'true'){
		$resultInSale = 1;
		$type = $_POST['type'];
	}
	else{
		$resultInSale = 0;
		$type = null;
	}
	
	if($_POST['followUpTrans'] == false)
		$previousTransactionID = null;
	else{
		if(isset($_POST['previousTransactionID']) && $_POST['previousTransactionID'] > 0)
			$previousTransactionID = $_POST['previousTransactionID'];
		else
			$previousTransactionID = null;
	}
	
	if($_POST['followUpReq'] == 'true')
		$followUpReq = 1;
	else
		$followUpReq = 0;
	$tra->updateTransaction($id,  $_POST['employeeID'], $_POST['pointOfContactId'], date('Y-m-d H:i:s',time()),
	$followUpReq, $type, $_POST['resultInSale'], $_POST['followUpTrans'], $previousTransactionID);
}

function deleteTransaction($id){
	global $db;

	$stmt = $db->prepare('DELETE FROM TRANSACTION WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$isSucessful = $stmt->execute();
	return $isSucessful;
}

function getAllTransactions($whereClauses = null){
	global $db;
	
	if($whereClauses != null){
		$where = ' WHERE';
		$count = 0;
		if(isset($whereClauses['employeeID']) && $whereClauses['employeeID'] > 0){
			$where .= ' employeeId = '.$whereClauses['employeeID'];
			$count++;
		}
		if(isset($whereClauses['pointOfContactId']) && $whereClauses['pointOfContactId'] > 0){
			if($count > 0 )
				$where .=' AND';
			$where .= ' pointOfContactId = '.$whereClauses['pointOfContactId'];
			$count++;
		}
		if(isset($whereClauses['followUpReq']) && $whereClauses['followUpReq'] =='true'){
			if($count > 0 )
				$where .=' AND';
			$where .= ' followUpReq = 1';
			$count++;
		}
		if(isset($whereClauses['resultInSale']) && $whereClauses['resultInSale'] =='true'){
			if($count > 0 )
				$where .=' AND';
			$where .= ' resultInSale = 1';
			$count++;
		}
		if(isset($whereClauses['type']) && $whereClauses['type'] > ''){
			if($count > 0 )
				$where .=' AND';
			$where .= " type = '".$whereClauses['type']."'";
			$count++;
		}
	}
	else
		$where = '';
	
	$sql = 'SELECT * FROM TRANSACTION'.$where;
	
	//print_r($sql);

	$stmt = $db->prepare($sql);
	$stmt->execute();
	while($transaction = $stmt->fetch(PDO::FETCH_ASSOC)){
		$emp = getEmployeeByID($transaction['employeeId'])[1];
		$poc = getPocByID($transaction['pointOfContactId'])[1];
		//print_r($poc);
		$transaction['employee'] = str_replace("'", "", $emp['fName'])." ".str_replace("'", "", $emp['lName']);
		$transaction['pointOfContact'] = str_replace("'", "", $poc['fName'])." ".str_replace("'", "", $poc['lName']);
		$transactions[] = $transaction;
	}
	if (isset($transactions) && count($transactions) > 0)
		return $transactions;
	else
		return null;
}


?>