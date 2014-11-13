<?php
include '../db_conn.php';
class PointOfContact{
	
	private $id;
	private $compId;
	private $fname;
	private $lname;
	private $email;
	private $phone;
	private $dateCreated;
	
	function __construct($compId, $fname, $lname, $email, $phone, $dateCreated){
		$this->setCompID($compId);
		$this->setFname($fname);
		$this->setLname($lname);
		$this->setEmail($email);
		$this->setPhone($phone);
		$this->setDateCreated($dateCreated);
	}
	
	function setID($id){
		$this->id = $id;
	}
	
	function setCompID($compId){
		$this->compId = $compId;
	}
	
	function setFname($fname){
		$this->fname = $fname;
	}
	
	function setLname($lname){
		$this->lname = $lname;
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
		return $this->compId;
	}
	
	function getFname(){
		return $this->fname;
	}
	
	function getLname(){
		return $this->lname;
	}
	
	function getEmail(){
		return $this->email;
	}
	
	function getphone(){
		return $this->phone;
	}
	
	function getDateCreated(){
		return $this->dateCreated;
	}
	
	function savePointOfContact($poc){
		try{
			$db->execute("INSERT INTO POINTOFCONTACT ('fname', 'lname', 'email', 'phone', 'dateCreated') VALUES ('".$this->getFname()."', '".$this->getLname()."', '".$this->getEmail()."', '".$this->getPhone()."', '".$this->getDateCreated()."')");
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'We are unable to process your request. Please try again later"';
		}
	}
	
	function getPocByID($id){
	$db->query('SELECT * FROM POINTOFCONTACT WHERE id = '.$id, PDO::FETCH_INTO, $poc);
	return $poc;
	}
	
	function getPocByCompID($compId){
	$db->query('SELECT * FROM POINTOFCONTACT WHERE companyID = '.$compId, PDO::FETCH_INTO, $poc);
	return $poc;
	}
	
	function insertPointOfContact(){
		$poc = new PointOfContact($_POST['lastName'], $_POST['firstName'], $_POST['email'], $_POST['phone'],date('Y-m-d H:i:s',time()));
		$poc->savePointOfContact($this);
	} 

	
?>
