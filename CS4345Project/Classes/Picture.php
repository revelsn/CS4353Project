<?php
include '../db_conn.php';
class Picture{
	public $id;
	public $size;
	public $dateCreated;
	public $mime;
	public $name;
	public $fileData;
	public $empID;
	public $contID;
	
	function __construct($size, $dateCreated, $mime, $name, $fileData, $empID=null, $contID=null){
		$this->size = $size;
		$this->dateCreated = $dateCreated;
		$this->mime = $mime;
		$this->name = $name;
		$this->fileData = $fileData;
		$this->empID = $empID;
		$this->contID = $contID;
	}
	
	function savePicture(){
		global $db;
		try{
			$stmt = $db->prepare("INSERT INTO Picture (size, dateCreated, mime, name, fileData, empID, contID) VALUES (:size, :date, :mime, :name, :fd, :emp, :cont)");
			$stmt->bindParam(':size', $this->size, PDO::PARAM_STR);
			$stmt->bindParam(':date', $this->dateCreated, PDO::PARAM_STR);
			//$locID = $this->getLocationID();
			$stmt->bindParam(':mime', $this->mime, PDO::PARAM_STR);
			//$date = $this->getDateEmployed();
			$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindParam(':fd', $this->fileData, PDO::PARAM_LOB);
			$stmt->bindParam(':emp', $this->empID, PDO::PARAM_INT );
			$stmt->bindParam(':cont', $this->contID, PDO::PARAM_INT );
			$stmt->execute();
		}
		catch(Exception $e)
		{
			/*** if we are here, something has gone wrong with the database ***/
			echo $e;
		}
	}

}

function insertPicture($empID = null, $contID = null){
	//echo "empid = ".$empID."<br/>";
	if(isset($_FILES['photo']['name']) && $_FILES['photo']['size'] > 0)
	{
		$fileName = $_FILES['photo']['name'];
		$tmpName  = $_FILES['photo']['tmp_name'];
		$fileSize = $_FILES['photo']['size'];
		$fileType = $_FILES['photo']['type'];
	
		$content = file_get_contents($_FILES["photo"]["tmp_name"]);
		//$content = base64_encode($image_content);
		if(!get_magic_quotes_gpc())
			$fileName = addslashes($fileName);
		
		$pic = new Picture($fileSize, date("Y-m-d H:i:s", time()), $fileType, $fileName, $content, $empID, $contID);
		/*echo "pic: ";
		print_r($pic);
		echo '<br />';*/
		$pic->savePicture();
	}
}

function getPictureByEmpID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM PICTURE WHERE empID = :id ORDER BY dateCreated');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$photo = $stmt->fetch(PDO::FETCH_ASSOC);
	return $photo;
}

function getPictureByPOCID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM PICTURE WHERE contID = :id ORDER BY dateCreated');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$photo = $stmt->fetch(PDO::FETCH_ASSOC);
	return $photo;
}

function getPictureByID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM PICTURE WHERE id = :id');
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$photo = $stmt->fetch(PDO::FETCH_ASSOC);
	return $photo;
}
?>