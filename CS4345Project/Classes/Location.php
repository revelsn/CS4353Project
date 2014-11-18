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
	
	function __construct($locationName, $city, $state='', $zip='', $streetAddr1 = '', $streetAddr2 = ''){
		$this->setLocationName($locationName);
		$this->setCity($city);
		$this->setState($state);
		$this->setZip($zip);
		$this->setStreetAddr1($streetAddr1);
		$this->setStreetAddr2($streetAddr2);
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
	
	function saveLocation(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO LOCATION (locationName, city, state, zip, streetAddr1, streetAddr2) VALUES (:locName, :city, :state, :zip, :sa1, :sa2)");
			$locName = $this->getLocationName();
			$stmt->bindParam(':locName', $locName, PDO::PARAM_STR);
			$city = $this->getCity();
			$stmt->bindParam(':city', $city, PDO::PARAM_STR);
			$state = $this->getState();
			$stmt->bindParam(':state', $state, PDO::PARAM_STR);
			$zip = $this->getZip();
			$stmt->bindParam(':zip', $date, PDO::PARAM_STR);
			$sa1 = $this->getStreetAddr1();
			$stmt->bindParam(':sa1', $sa1, PDO::PARAM_STR);
			$sa2 = $this->getStreetAddr2();
			$stmt->bindParam(':sa2', $sa2, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}
	
	function updateLocation($id, $locationName, $city, $state, $zip, $streetAddr1, $streetAddr2){
		global $db;
		try{
			$stmt = $db->prepare("UPDATE LOCATION SET locationName = :locName, city = :city, state = :state, zip = :zip, streetAddr1 = :sa1, streetAddr2 = :sa2 WHERE id = :id");
			$locationName = $db->quote($locationName);
			$stmt->bindParam(':locName', $locationName, PDO::PARAM_STR);
			$city = $db->quote($city);
			$stmt->bindParam(':city', $city, PDO::PARAM_STR);
			//$state = $db->quote($state);
			$stmt->bindParam(':state', $state, PDO::PARAM_STR);
			//$zip = $db->quote($zip);
			$stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
			$streetAddr1 = $db->quote($streetAddr1);
			$stmt->bindParam(':sa1', $streetAddr1, PDO::PARAM_STR);
			$streetAddr2 = $db->quote($streetAddr2);
			$stmt->bindParam(':sa2', $streetAddr2, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo '<br>'.$e;
		}
	}
	
	function locationArrayToObject($id){
		global $db;
		$stmt = $db->prepare('SELECT * FROM LOCATION WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		$loc = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$this->locationName = $loc['locationName'];
		$this->city = $loc['city'];
		$this->state = $loc['state'];
		$this->zip = $loc['zip'];
		$this->streetAddr1 = $loc['streetAddr1'];
		$this->streetAddr2 = $loc['streetAddr2'];
		return $this;
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
	$location = new Location($_POST['locationName'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['streetAddr1'], $_POST['streetAddr2']);
	$location->saveLocation();
}

function updateLocation($id){
	$location = new Location('', '');
	$location->locationArrayToObject($id);
	$location->updateLocation($id, $_POST['locationName'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['streetAddr1'], $_POST['streetAddr2']);
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