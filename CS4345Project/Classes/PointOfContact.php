<?php
include '../db_conn.php';
include_once 'Picture.php';
class PointOfContact{
	
	public $id;
	public $companyID;
	public $fName;
	public $lName;
	public $email;
	public $phone;
	public $dateCreated;
	
	function __construct($companyID, $fName, $lName, $email, $phone, $dateCreated){
		$this->setCompID($companyID);
		$this->setFname($fName);
		$this->setLname($lName);
		$this->setEmail($email);
		$this->setPhone($phone);
		$this->setDateCreated($dateCreated);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setCompID($companyID){
		$this->companyID = $companyID;
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
		return $this->companyID;
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
			$stmt = $db->prepare("INSERT INTO POINTOFCONTACT (companyID, fName, lName, email, phone, dateCreated) VALUES (:companyID, :fName, :lName, :email, :phone, :dateCreated)");
			$companyID = $this->getCompID();
			$stmt->bindParam(':companyID', $companyID, PDO::PARAM_STR);
			$fName = $this->getFname();
			$stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
			$lName = $this->getLname();
			$stmt->bindParam(':lName', $lName, PDO::PARAM_STR);
			$email = $this->getEmail();
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$phone = $this->getPhone();
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$dateCreated = $this->getDateCreated();
			$stmt->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}

	function updatePointOfContact($id, $companyID, $fName, $lName, $email, $phone){
		global $db;
		try{
			if(isset($_FILES['photo']['name']) && $_FILES['photo']['size'] > 0)
				insertPicture(null,$id);
			$stmt = $db->prepare("UPDATE POINTOFCONTACT SET companyID = :companyID, lName = :lName, fName = :fName, lName = :lName, email = :email, phone = :phone WHERE id = :id");
			$compId = $db->quote($companyID);
			$stmt->bindParam(':companyID', $companyID, PDO::PARAM_INT);
			$fName = $db->quote($fName);
			$stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
			$lName = $db->quote($lName);
			$stmt->bindParam(':lName', $lName, PDO::PARAM_STR);
			$email = $db->quote($email);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$phone = $db->quote($phone);
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
		$poc = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->companyID = $poc['companyID'];
		$this->dateCreated = $poc['dateCreated'];
		$this->fName = $poc['fName'];
		$this->lName = $poc['lName'];
		$this->email = $poc['email'];
		$this->phone = $poc['phone'];
		return $this;
	}
	
}

function getPocByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM POINTOFCONTACT WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$poc= $stmt->fetch(PDO::FETCH_ASSOC);
	
	$stmt = $db->prepare('SELECT * FROM COMPANY c JOIN POINTOFCONTACT p ON c.id = p.companyID WHERE p.id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$comp = $stmt->fetch(PDO::FETCH_ASSOC);
	$poc['companyName'] = $comp['companyName'];

	/* We will wrap in in an array so we can use the foreach on the showEmployee page */
	$tempArray['1'] = $poc;
	return $tempArray;
}

function insertPointOfContact(){
	$poc = new PointOfContact($_POST['companyID'],$_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone'],date('Y-m-d H:i:s',time()));
	//print_r($poc);
	$poc->savePointOfContact();
}

function updatePointOfContact($id){
	$poc = new PointOfContact('', '', '', '', '', '');
	$poc->pointOfContactArrayToObject($id);
	$poc->updatePointOfContact($id, $_POST['companyID'], $_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone']);
}

function deletePointOfContact($id){
	global $db;
	
	$isSucessful = deletePictureByPOCID($id);
	
	$stmt = $db->prepare('DELETE FROM POINTOFCONTACT WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$isSucessful2 = $stmt->execute();

	return ($isSucessful && $isSucessful2);
}
	
function getAllPointsOfContact(){
	global $db;

	$stmt = $db->prepare('SELECT * FROM POINTOFCONTACT');
	$stmt->execute();
	while($cont = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($cont);
		$stmt2 = $db->prepare('SELECT * FROM COMPANY c JOIN POINTOFCONTACT p ON c.id = p.companyID WHERE c.id = :id');
		$stmt2->bindParam(':id', $cont['companyID'], PDO::PARAM_STR);
		$stmt2->execute();
		$company = $stmt2->fetch(PDO::FETCH_ASSOC);
		//print_r($company);
		$cont['companyName'] = $company['companyName'];
		$cont['isIndividual'] = $company['isIndividual'];
		$contacts[] = $cont;
	}
	return $contacts;
}

?>
