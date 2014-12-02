<?php
include '../db_conn.php';
class Company{
	
	public $id;
	public $companyName;
	public $dateCreated;
	public $isIndividual;
	
	function __construct($companyName, $dateCreated, $isIndividual = 0){
		$this->setCompname($companyName);
		$this->setDateCreated($dateCreated);
		$this->setIsIndividual($isIndividual);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setCompName($companyName){
		$this->companyName = $companyName;
	}
	
	function setDateCreated($dateCreated){
		$this->dateCreated = $dateCreated;
	}
	
	function setIsIndividual($is){
		$this->isIndividual = $is;
	}
	
	function getID(){
		return $this->id;
	}
	
	function getCompName(){
		return $this->companyName;
	}
	
	function getDateCreated(){
		return $this->dateCreated;
	}
	
	function getIsIndividual(){
		return $this->isIndividual;
	}
	
	function saveCompany(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO COMPANY (companyName, dateCreated, isIndividual) VALUES (:companyName,:dateCreated, :isIndividual)");
			$companyName = $this->getCompName();
			$stmt->bindParam(':companyName', $companyName, PDO::PARAM_STR);
			$dateCreated = $this->getDateCreated();
			$stmt->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
			$isInd = $this->getIsIndividual();
			$stmt->bindParam(':isIndividual', $isInd, PDO::PARAM_INT);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}
	
	function updateCompany($id, $companyName, $isIndv){
		global $db;
		try{
			$stmt = $db->prepare("UPDATE COMPANY SET companyName = :compName, isIndividual = :isIndividual WHERE id = :id");
			$companyName = $db->quote($companyName);
			$stmt->bindParam(':compName', $companyName, PDO::PARAM_STR);
			$stmt->bindParam(':isIndividual', $isIndv, PDO::PARAM_INT);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo '<br>'.$e;
		}
	}
		
	function companyArrayToObject($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM COMPANY WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$comp = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->id = $comp['id'];
		$this->compName = $comp['companyName'];
		$this->dateCreated = $comp['dateCreated'];
		$this->isIndividual = $comp['isIndividual'];
		return $this;
	}
}
	
function getCompanyByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM COMPANY WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$comp = $stmt->fetch(PDO::FETCH_ASSOC);

	/* We will wrap in in an array so we can use the foreach on the showCompany page */
	$tempArray['1'] = $comp;
	return $tempArray;
}

function insertCompany(){
	if($_POST['isIndividual'] == 'true')
		$isInv = 1;
	else
		$isInv = 0;
	$comp = new Company($_POST['companyName'],date('Y-m-d H:i:s',time()), $isInv);
	print_r($comp);
	$comp->saveCompany();
} 

function deleteCompany($id){
	global $db;

	$stmt = $db->prepare('DELETE FROM COMPANY WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$isSucessful = $stmt->execute();

	return $isSucessful;
}

function updateCompany($id){
	$comp = new Company('', '');
	$comp->companyArrayToObject($id);
	if($_POST['isIndividual'] == 'true')
		$isInv = 1;
	else
		$isInv = 0;
	$comp->updateCompany($id, $_POST['companyName'], $isInv);
}

function getAllCompanies(){
	global $db;
	
	$stmt = $db->prepare('SELECT * FROM COMPANY');
	$stmt->execute();
	while($comp = $stmt->fetch(PDO::FETCH_ASSOC)){
		if($comp['isIndividual']){
			$stmt2 = $db->prepare('SELECT * FROM POINTOFCONTACT p JOIN COMPANY c ON c.id = p.companyID WHERE c.id = :id');
			$stmt2->bindParam(':id', $comp['id'], PDO::PARAM_STR);
			$stmt2->execute();
			$poc = $stmt2->fetch(PDO::FETCH_ASSOC);
			//print_r($poc);
			$comp['indvName'] = str_replace("'", "", $poc['fName'])." ".str_replace("'", "", $poc['lName']);
			$comp['indvID'] = $poc['id'];
		}
		$companies[] = $comp;
	}
	return $companies;
}	
?>
