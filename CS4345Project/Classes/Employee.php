<?php
include '../db_conn.php';
include 'Picture.php';
class Employee{
	
	public $id;
	public $lName;
	public $fName;
	public $locationID;
	public $dateEmployed;
	
	function __construct($lname, $fname, $locationid, $datecreated){
		$this->setLname($lname);
		$this->setFname($fname);;
		$this->setLocationID($locationid);
		$this->setDateEmployed($datecreated);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setLname($lname){
		$this->lName = $lname;
	}
	
	function setFname($fname){
		$this->fName = $fname;
	}
	
	function setLocationID($locationId){
		$this->locationID = $locationId;
	}
	
	function setDateEmployed($dateEmployed){
		$this->dateEmployed = $dateEmployed;
	}
	
	function getID(){
		return $this->id;
	}
	
	function getLname(){
		return $this->lName;
	}
	
	function getFname(){
		return $this->fName;
	}
	
	function getLocationID(){
		return $this->locationID;
	}
	
	function getDateEmployed(){
		return $this->dateEmployed;
	}
	
	
	function saveEmployee(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO EMPLOYEE (lName, fName, locationID, dateEmployed) VALUES (:lName, :fName, :locID, :date)");
			$lName = $this->getLname();
			$stmt->bindParam(':lName', $lName, PDO::PARAM_STR);
			$fName = $this->getFname();
			$stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
			$locID = $this->getLocationID();
			$stmt->bindParam(':locID', $locID, PDO::PARAM_STR);
			$date = $this->getDateEmployed();
			$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}
	
	function updateEmployee($id, $fName, $lName, $locID){
		global $db;
		try{
			if(isset($_FILES['photo']['name']) && $_FILES['photo']['size'] > 0)
				insertPicture($id);
			$stmt = $db->prepare("UPDATE EMPLOYEE SET lname = :lName, fname = :fName, locationID = :locID WHERE id = :id");
			$lName = $db->quote($lName);
			$stmt->bindParam(':lName', $lName, PDO::PARAM_STR);
			$fName = $db->quote($fName);
			$stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
			$stmt->bindParam(':locID', $locID, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo '<br>'.$e;
		}
	}
	
	function employeeArrayToObject($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM EMPLOYEE WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$emp = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$stmt = $db->prepare('SELECT * FROM LOCATION l JOIN EMPLOYEE e ON l.id = e.locationid WHERE e.id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$location = $stmt->fetch(PDO::FETCH_ASSOC);
		$emp['location'] = $location['locationName'];
		
		$this->dateEmployed = $emp['dateEmployed'];
		$this->fName = $emp['fName'];
		$this->lName = $emp['lName'];
		$this->locationId = $emp['locationID'];
		return $this;
	}
	
}

function getEmployeeByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM EMPLOYEE WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$emp = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$stmt = $db->prepare('SELECT * FROM LOCATION l JOIN EMPLOYEE e ON l.id = e.locationid WHERE e.id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$location = $stmt->fetch(PDO::FETCH_ASSOC);
	$emp['location'] = $location['locationName'];
	
	//We will wrap in in an array so we can use the foreach on the showEmployee page
	$tempArray['1'] = $emp;
	return $tempArray;
}


function insertEmployee(){
	$emp = new Employee($_POST['lName'], $_POST['fName'], $_POST['locationID'], date('Y-m-d H:i:s',time()));
	print_r($emp);
	$emp->saveEmployee();
}

function updateEmployee($id){
	$emp = new Employee('', '', '', '');
	$emp->employeeArrayToObject($id);
	$emp->updateEmployee($id, $_POST['fName'], $_POST['lName'], $_POST['locationID']);
}

function deleteEmployee($id){
	global $db;

	$stmt = $db->prepare('DELETE FROM EMPLOYEE WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$isSucessful = $stmt->execute();
	return $isSucessful;
}

function getAllEmployees(){
	global $db;
	
	$stmt = $db->prepare('SELECT * FROM EMPLOYEE');
	$stmt->execute();
	while($employee = $stmt->fetch(PDO::FETCH_ASSOC)){
		$stmt2 = $db->prepare('SELECT * FROM LOCATION l JOIN EMPLOYEE e ON l.id = e.locationid WHERE e.id = :id');
		$stmt2->bindParam(':id', $employee['id'], PDO::PARAM_STR);
		$stmt2->execute();
		$location = $stmt2->fetch(PDO::FETCH_ASSOC);
		$employee['location'] = $location['locationName'];
		$employees[] = $employee;
	}
	return $employees;
}

?>