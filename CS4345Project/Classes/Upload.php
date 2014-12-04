<?php
include '../db_conn.php';
class Upload{
	public $id;
	public $size;
	public $dateCreated;
	public $mime;
	public $name;
	public $fileData;
	public $transactionID;
	public $description;
	
	function __construct($size, $dateCreated, $mime, $name, $fileData, $transactionID, $description){
		$this->size = $size;
		$this->dateCreated = $dateCreated;
		$this->mime = $mime;
		$this->name = $name;
		$this->fileData = $fileData;
		$this->transactionID = $transactionID;
		$this->description = $description;
	}
	
	function saveUpload(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO UPLOADS (size, dateCreated, mime, name, fileData, transactionID, description) VALUES (:size, :date, :mime, :name, :fd, :transactionID, :description)");
			$stmt->bindParam(':size', $this->size, PDO::PARAM_STR);
			$stmt->bindParam(':date', $this->dateCreated, PDO::PARAM_STR);
			//$locID = $this->getLocationID();
			$stmt->bindParam(':mime', $this->mime, PDO::PARAM_STR);
			//$date = $this->getDateEmployed();
			$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindParam(':fd', $this->fileData, PDO::PARAM_LOB);
			$stmt->bindParam(':transactionID', $this->transactionID, PDO::PARAM_INT );
			$stmt->bindParam(':description', $this->contID, PDO::PARAM_INT );
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}

}

function insertUpload($transactionID, $description){
	//echo "empid = ".$empID."<br/>";
	if(isset($_FILES['upload']['name']) && $_FILES['upload']['size'] > 0)
	{
		$fileName = $_FILES['upload']['name'];
		$tmpName  = $_FILES['upload']['tmp_name'];
		$fileSize = $_FILES['upload']['size'];
		$fileType = $_FILES['upload']['type'];
	
		$content = file_get_contents($_FILES["upload"]["tmp_name"]);
		//$content = base64_encode($image_content);
		if(!get_magic_quotes_gpc())
			$fileName = addslashes($fileName);
		
		$upload = new Upload($fileSize, date("Y-m-d H:i:s", time()), $fileType, $fileName, $content, $transactionID, $description);
		/*echo "pic: ";
		print_r($pic);
		echo '<br />';*/
		$upload->saveUpload();
	}
}

function getUploadsByTransID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM UPLOADS WHERE transactionID = :id ORDER BY dateCreated DESC');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	while($upload = $stmt->fetch(PDO::FETCH_ASSOC)){
		$uploads[] = $upload;
	}
	return $uploads;
}

function getUploadByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM UPLOADS WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$photo = $stmt->fetch(PDO::FETCH_ASSOC);
	return $photo;
}
?>