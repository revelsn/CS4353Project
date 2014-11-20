<?php
include '../db_conn.php';
class Company{
	
	private $id;
	private $compName;
	private $dateCreated;
	
	function __construct($compName, $dateCreated){
		$this->setCompname($compName);
		$this->setDateCreated($dateCreated);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setCompName($id){
		$this->compName = $compName;
	}
	
	function setDateCreated($dateCreated){
		$this->dateCreated = $dateCreated;
	}
	
	function getID(){
		return $this->id;
	}
	
	function getCompName(){
		return $this->compName;
	}
	
	function getDateCreated(){
		return $this->dateCreated;
	}
	
	function saveCompany(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO COMPANY (compName, dateCreated) VALUES (:compName,:dateCreated)");
			$compName = $this->getCompName();
			$stmt->bindParam(':compName', $compname, PDO::PARAM_STR);
			$dateCreated = $this->getDateCreated();
			$stmt->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}
	
	function updateCompany($id, $compName, $dateCreated){
		global $db;
		try{
			$stmt = $db->prepare("UPDATE POINTOFCONTACT SET compName = :compName, dateCreated = :dateCreated WHERE id = :id");
			$compName = $db->quote($compName);
			$stmt->bindParam(':compName', $compName, PDO::PARAM_STR);
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
		
	function companyArrayToObject($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM COMPANY WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$comp = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->compName = $comp['compId'];
		$this->dateCreated = $comp['dateCreated'];
		return $this;
	}
	
	function getPocByID($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM COMPANY WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$comp = $stmt->fetch(PDO::FETCH_ASSOC);
	
		/* We will wrap in in an array so we can use the foreach on the showEmployee page */
		$tempArray['1'] = $comp;
		return $tempArray;
	}
	
	function insertPointOfContact(){
		$comp = new PointOfContact($_POST['compName'],date('Y-m-d H:i:s',time()));
		print_r($comp);
		$comp->savePointOfContact();
	} 
	
	function updatePointOfContact($id){
		$comp = new Company('', '');
		$comp->companyArrayToObject($id);
		$comp->updateCompany($id, $_POST[compName], $_POST['dateCreated']);
	}
	
?>
