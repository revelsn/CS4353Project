<?php
include '../db_conn.php';
class Employee{
	
	private $id;
	private $lname;
	private $fname;
	private $locationid;
	private $datecreated;
	
	function __construct($lname, $fname, $locationid, $datecreated){
		$this->setLname($lname);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setLname($lname){
		$this->lname = $lname;
	}
	
	function setFname($fname){
		$this->fname = $fname;
	}
	
	function setLocationID($locationid){
		$this->locationid = $locationid;
	}
	
	function setDateCreated($datecreated){
		$this->datecreated = $datecreated;
	}
	
	function getID(){
		return $this->id;
	}
	
	function getLname(){
		return $this->lname;
	}
	
	function getFname(){
		return $this->fname;
	}
	
	function getLocationID(){
		return $this->locationid;
	}
	
	function getDateCreated(){
		return $this->datecreated;
	}
	
	
	function saveEmployee($employee){
		try{
			$db->execute("INSERT INTO EMPLOYEE ('lname', 'fname', 'locationid', 'datecreated') VALUES ('".$this->getLname()."', '".$this->getFname()."', '".$this->getLocationID()."', '".$this->getDateCreated()."')");
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'We are unable to process your request. Please try again later"';
		}
	}
	
}

function getEmployeeByID($id){
	$db->query('SELECT * FROM EMPLOYEE WHERE id = '.$id, PDO::FETCH_INTO, $emp);
	return $emp;
}

function insertEmployee(){
	$emp = new Employee($_POST['lastName'], $_POST['firstName'], $_POST['locationID'], date('Y-m-d H:i:s',time()));
	$emp->saveEmployee($this);
}

?>