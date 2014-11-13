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
	
	function savePointOfContact($comp){
		try{
			$db->execute("INSERT INTO COMPANY ('compName', 'dateCreated') VALUES ('".$this->getCompName()."', '".$this->getDateCreated()."')");
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'We are unable to process your request. Please try again later"';
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
