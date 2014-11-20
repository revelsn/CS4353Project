<?php
include '../db_conn.php';
include 'Picture.php';
class PointOfContact{
	
	private $id;
	private $compId;
	private $fName;
	private $lName;
	private $email;
	private $phone;
	private $dateCreated;
	
	function __construct($compId, $fName, $lName, $email, $phone, $dateCreated){
		$this->setCompID($compId);
		$this->setFname($fName);
		$this->setLname($lName);
		$this->setEmail($email);
		$this->setPhone($phone);
		$this->setDateCreated($dateCreated);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setCompID($compId){
		$this->compId = $compId;
	}
	
	function setFname($fName){
		$this->fName = $fName;
	}
	
	function setLname($lName){
		$this->lName = $lName;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function setPhone($phone){
		$this->phone = $phone;
	}
	
	function setDateCreated($dateCreated){
		$this->dateCreated = $dateCreated;
	}
	
	function getID(){
		return $this->id;
	}
	
	function getCompID(){
		return $this->compId;
	}
	
	function getFname(){
		return $this->fName;
	}
	
	function getLname(){
		return $this->lName;
	}
	
	function getEmail(){
		return $this->email;
	}
	
	function getPhone(){
		return $this->phone;
	}
	
	function getDateCreated(){
		return $this->dateCreated;
	}
	
	function savePointOfContact(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO POINTOFCONTACT (compId, fName, lName, email, phone, dateCreated) VALUES (:compId, :fName, :lName, :email, :phone, :dateEmployed)");
			$compId = $this->getCompID();
			$stmt->bindParam(':compId', $compId, PDO::PARAM_STR);
			$compId = $this->getFname();
			$stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
			$compId = $this->getLname();
			$stmt->bindParam(':lName', $lName, PDO::PARAM_STR);
			$compId = $this->getEmail();
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$compId = $this->getPhone();
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$compId = $this->getDateCreated();
			$stmt->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}
	
	function updatePointOfContact($id, $compId, $fName, $lName, $email, $phone, $dateCreated){
		global $db;
		try{
			if(isset($_FILES['photo']['name']) && $_FILES['photo']['size'] > 0)
				insertPicture(null,$id);
			$stmt = $db->prepare("UPDATE POINTOFCONTACT SET compId = :compId, lName = :lName, fName = :fName, lName = :lName, email = :email, phone = :phone, dateCreated = :dateCreated WHERE id = :id");
			$compId = $db->quote($compId);
			$stmt->bindParam(':compId', $compId, PDO::PARAM_STR);
			$fName = $db->quote($fName);
			$stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
			$lName = $db->quote($lName);
			$stmt->bindParam(':lName', $lName, PDO::PARAM_STR);
			$email = $db->quote($email);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$phone = $db->quote($phone);
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$dateCreated = $db->quote($dateCreated);
			$stmt->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo '<br>'.$e;
		}
	}
	
	function pointOfContactArrayToObject($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM POINTOFCONTACT WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$emp = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->compId = $poc['compId'];
		$this->dateCreated = $poc['dateCreated'];
		$this->fName = $poc['fName'];
		$this->lName = $poc['lName'];
		$this->email = $poc['email'];
		$this->phone = $poc['phone'];
		return $this;
	}
	
	function getPocByID($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM POINTOFCONTACT WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$poc= $stmt->fetch(PDO::FETCH_ASSOC);
	
		/* We will wrap in in an array so we can use the foreach on the showEmployee page */
		$tempArray['1'] = $poc;
		return $tempArray;
	}
	
	function insertPointOfContact(){
		$poc = new PointOfContact($_POST['compId'],$_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone'],date('Y-m-d H:i:s',time()));
		print_r($poc);
		$poc->savePointOfContact();
	} 
	
	function updatePointOfContact($id){
	$poc = new PointOfContact('', '', '', '', '', '');
	$poc->pointOfContactArrayToObject($id);
	$poc->updateEmployee($id, $_POST[compId], $_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone'], $_POST['dateCreated']);
}

	
?>
