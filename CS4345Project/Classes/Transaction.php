<?php
include '../db_conn.php';
include 'Picture.php';
class Transaction{

	private $id;
	private $employeeId;
	private $pointOfContactId;
	private $date;
	private $followUpReq;
	private $type;
	private $resultInSale;
	private $note;
	private $followUpTransId;

	function __construct($employeeId, $pointOfContactId, $date, $followUpReq, $type, $resultInSale, $followUpTransId){
		$this->setEmployeeId($employeeId);
		$this->setPointOfContactId($pointOfContactId);
		$this->setDate($date);
		$this->setFollowUpReq($followUpReq);
		$this->setType($type);
		$this->setResultInSale($resultInSale);
		$this->setFollowUpTransId($followUpTransId);
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

	function setFollowUpReq($followUpReq){
		$this->followUpReq = $followUpReq;
	}
	
	function setType($type){
		$this->type = $type;
	}
	
	function setResultInSale($resultInSale){
		$this->resultInSale = $resultInSale;
	}
	
	function setFollowUpTransId($followUpTransId){
		$this->followUpTransId = $followUpTransId;
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
	
	function getFollowUpTransId(){
		return $this->followUpTransId;
	}


	function saveTransaction(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO TRANSACTION ('employeeId', 'pointOfContactId', 'date', 'followUpReq','type','resultInSale',
					'followUpTransId') VALUES (:employeeId, :pointOfContactId, :date, :followUpReq, :type, :resultInSale)");
			$employeeID = $this->getEmployeeId();
			$stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
			$pointOfContactId = $this->getPointOfContactId();
			$stmt->bindParam(':pointOfContactID', $pointOfContactID, PDO::PARAM_STR);
			$date = $this->getDate();
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$followUpReq = $this->getFollowUpReq();
			$stmt->bindParam(':followUpReq', $followUpReq, PDO::PARAM_STR);
			$type = $this->getType();
			$stmt->bindParam(':type', $type, PDO::PARAM_STR);
		    $resultInSale = $this->getResultInSale();
		    $stmt->bindParam(':resultInSale', $resultInSale, PDO::PARAM_STR);
			$followUpTransId = $this->getFollowUpTransId();
			$stmt->bindParam(':followUpTransId', $followUpTransId, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}

	function updateTransaction($id, $employeeID, $pointOfContactId, $date, $followUpReq, $type, $resultInSale, $followUpTransId){
		global $db;
		try{
			if(isset($_FILES['photo']['name']) && $_FILES['photo']['size'] > 0)
				insertPicture($id);
			$stmt = $db->prepare("UPDATE TRANSACTION SET employeeId = :employeeId, pointOfContactId = :pointOfContactId, date = :date, followUpReq = :followUpReq,
					type = :type, resultInSale = :resultInSale, followUpTransId = :followUpTransId  WHERE id = :id");
			$stmt->bindParam(':employeeId', $employeeID, PDO::PARAM_STR);
			$stmt->bindParam(':pointOfContactId', $pointOfContactId, PDO::PARAM_STR);
			$date = $db->quote($date);
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$followUpReq = $db->quote($followUpReq);
			$stmt->bindParam(':followUpReq', $followUpReq, PDO::PARAM_STR);
			$type = $db->quote($type);
			$stmt->bindParam(':type', $type, PDO::PARAM_STR);
			$resultInSale = $db->quote($resultInSale);
			$stmt->bindParam(':resultInSale', $resultInSale, PDO::PARAM_STR);
			$followUpTransId = $db->quote($followUpTransId);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo '<br>'.$e;
		}
	}
	
	function getTransactionByID($id){
		$db->query('SELECT * FROM TRANSACTION WHERE id = '.$id, PDO::FETCH_INTO, $emp);
		return $emp;
}

function insertTransaction(){
	$emp = new Transaction($_POST['employeeId'], $_POST['pointOfContactId'], date('Y-m-d H:i:s'), $_POST['followUpReq'],
					 $_POST['type'], $_POST['resultInSale'], $_POST['followUpTransId']);
	$emp->saveTransaction($this);
}

?>