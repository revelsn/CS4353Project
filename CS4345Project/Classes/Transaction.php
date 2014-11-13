<?php
include '../db_conn.php';
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
		$this->setLname($lname);
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


	function saveTransaction($transaction){
		try{
			$db->execute("INSERT INTO TRANSACTION ('employeeId', 'pointOfContactId', 'date', 'followUpReq','type','resultInSale',
					'followUpTransId') VALUES ('".$this->getEmployeeId()."', '".$this->getgetPointOfContactId()."', '".$this->getDate()
					."', '".$this->getFollowUpReq()."','".$this->getType()."','".$this->getResultInSale()
					."','".$this->getFollowUpTransId()."');
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'We are unable to process your request. Please try again later';
		}
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