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
	
	function saveCompany($comp){
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
	
	function getCompByID($id){
	$db->query('SELECT * FROM COMPANY WHERE id = '.$id, PDO::FETCH_INTO, $comp);
	return $comp;
	}
	
	function insertCompany(){
		$comp = new Company($_POST['compName'],  date('Y-m-d H:i:s',time()));
		$comp->saveCompany($this);
	}

	
?>
