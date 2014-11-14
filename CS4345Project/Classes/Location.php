<?php
include '../db_conn.php';
class Location{
	
	private $id;
	private $locationName;
	private $city;
	private $state;
	private $zip;
	private $streetAddr1;
	private $streetAddr2;
	
	function __construct($locationName, $city, $state, $zip, $streetAddr1 = '', $streetAddr2 = ''){
		$this->setLname($lname);
		$this->setFname($fname);;
		$this->setLocationID($locationid);
		$this->setDateEmployed($datecreated);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setLocationName($locationName){
		$this->locationName = $locationName;
	}
	
	function setCity($city){
		$this->city = $city;
	}
	
	function setState($state){
		$this->state = $state;
	}
	
	function setZip($zip){
		$this->zip = $zip;
	}
	
	function setStreetAddr1($streetAddr1){
		$this->streetAddr1 = $streetAddr1;
	}
	
	function setStreetAddr2($streetAddr2){
		$this->streetAddr2 = $streetAddr2;
	}
	
	function getID(){
		return $this->id;
	}
	
	function getLocationName(){
		return $this->locationName;
	}
	
	function getCity(){
		return $this->city;
	}
	
	function getState(){
		return $this->state ;
	}
	
	function getZip(){
		return $this->zip;
	}
	
	function getStreetAddr1(){
		return $this->streetAddr1;
	}
	
	function getStreetAddr2(){
		return $this->streetAddr2 ;
	}
	
	function saveEmployee($employee){
		try{
			$db->execute("INSERT INTO LOCATION ('locationName', 'city', 'state', 'zip', 'streetAddr1', 'streetAddr2') VALUES ('".$this->getLocationName()."', '".$this->getCity()."', '".$this->getState()."', '".$this->getZip()."', '".$this->getStreetAddr1()."', '".$this->getStreetAddr2()."')");
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'We are unable to process your request. Please try again later"';
		}
	}
	
}

function getLocationByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM LOCATION WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$loc = $stmt->fetch(PDO::FETCH_ASSOC);
	
	//We will wrap in in an array so we can use the foreach on the showLocation page
	$tempArray['1'] = $loc;
	return $tempArray;
}

function insertLocation(){
	if(!is_string($_POST['streetAddr1']))
		$_POST['streetAddr1'] = '';
	if(!is_string($_POST['streetAddr2']))
		$_POST['streetAddr2'] = '';
	$location = new Location($_POST['locationName'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['streetAddr1'], $_POST['$streetAddr2']);
	$emp->saveEmployee($this);
}

function getAllLocations(){
	global $db;
	
	$stmt = $db->prepare('SELECT * FROM LOCATION');
	$stmt->execute();
	while($loc = $stmt->fetch(PDO::FETCH_ASSOC)){
		$locations[] = $loc;
	}
	return $locations;
}

?>