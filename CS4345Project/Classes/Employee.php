<?php
include '../db_conn.php';
class Employee{
	
	private $id;
	private $lname;
	private $fname;
	
	function __construct($lname, $fname, $locationid, $datecreated){
		$this->setLname($lname);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setLname($lname){
		$this->lname = $lname;
	}
	
	function saveEmployee($employee){
		try{
			$db->execute("INSERT INTO EMPLOYEE ('lname') VALUES ('".$this->lname."')");
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'We are unable to process your request. Please try again later"';
		}
		$db = null;
		
	}
	
}

function getEmployeeByID($id){
	$db->query('SELECT * FROM EMPLOYEE WHERE id = '.$id, PDO::FETCH_INTO, $emp);
	return $emp;
}

function insertEmployee(){
	$emp = new Employee($_POST['lastName']);
	$emp->saveEmployee($this);
}

?>