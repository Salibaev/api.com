<?php
include('connection/connection.class.php');
/**
* Client class verify what method was sent and execute the respective method.
*/
class Iz_status2
{
	//Attributes
	private $status;
	private $ad_id;
	private $db;
	private $method;
	function __construct($status = '',$ad_id = '')
	{
		# Construct the class and set the values in the attributes.
		$this->db = ConnectionDB::getInstance();
		$this->status = $status;
		$this->ad_id = $ad_id;

	}

	function verifyMethod($method,$route){
		//Verifies what is the method sent.
		switch ($method) {
		case 'GET':
			# When the method is GET, returns the client
			return self::doGet($route);
			break;
		case 'POST':
			# When the method is POST, includes a new client
			if(empty($route[1])){
				return self::doPost();
			}else{
				return $arr_json = array('status' => 404);
			} 
			break;
		case 'PUT':
			# When the method is PUT, alters an existing client
			return self::doPut($route); 
			break;
		case 'DELETE':
			# When the method is DELETE, excludes an existing client.
			return self::doDelete($route); 
			break;		
		default:
			# When the method is different of the previous methods, return an error message.
			return array('status' => 405);
      		break;
		}
	}

	function doGet($route){
		//GET method
		$sql = 'SELECT * FROM client1';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':location', $this->location);
	    $stmt->execute();

	    if($stmt->rowCount() > 0)
	    {
	    	header('Access-Control-Allow-Origin: *');
	    	header("Access-Control-Allow-Headers: *");
	    	$row  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $arr_json = array('status' => 200, 'posts' => $row);
	    }else{
			return $arr_json = array('status' => 405);
	    }
	}
	function doPost(){
		//POST method
		$sql = 'UPDATE birimdik.client1 
						SET 
						status = :status
						WHERE id = :ad_id';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':status', $this->status);
	    $stmt->bindValue(':ad_id', $this->ad_id);

	   
	    // $stmt->bindValue(':image',$this->image['name']);
	 //    $target_dir = "uploads/";
		// $target_file = $target_dir . basename($this->image["name"]);
		// $uploadOk = 1;
		// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// // Check if image file is a actual image or fake image
		// if(isset($_POST["submit"])) {
		//   $check = getimagesize($this->image["tmp_name"]);
		//   if($check !== false) {
		//     echo "File is an image - " . $check["mime"] . ".";
		//     $uploadOk = 1;
		//   } else {
		//     echo "File is not an image.";
		//     $uploadOk = 0;
		//   }
		// }

		// // Check if file already exists
		// if (file_exists($target_file)) {
		//   echo "Sorry, file already exists.";
		//   $uploadOk = 0;
		// }

		// // Check file size
		// if ($this->image["size"] > 500000) {
		//   echo "Sorry, your file is too large.";
		//   $uploadOk = 0;
		// }

		// // Allow certain file formats
		// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		// && $imageFileType != "gif" ) {
		//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		//   $uploadOk = 0;
		// }

		// // Check if $uploadOk is set to 0 by an error
		// if ($uploadOk == 0) {
		//   echo "Sorry, your file was not uploaded.";
		// // if everything is ok, try to upload file
		// } else {
		//   if (move_uploaded_file($this->image["tmp_name"], $target_file)) {
		//     echo "The file ". htmlspecialchars( basename( $this->image["name"])). " has been uploaded.";
		//   } else {
		//     echo "Sorry, there was an error uploading your file.";
		//   }
		// }
	    $stmt->execute();

	    if($stmt->rowCount() > 0)
	    {	
	    	header('Access-Control-Allow-Origin: *');
	    	header("Access-Control-Allow-Headers: *");
			return $arr_json = array('status' => 200);
	    }else{
			return $arr_json = array('status' => 404);
	    }
		
	}
	function doPut($route){
		//PUT method
		$sql = 'UPDATE birimdik.client1 
						SET 
						name = :name,
						age = :age, 
						gender = :gender
						WHERE id = :id';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':name', $this->name);
	    $stmt->bindValue(':age', $this->age);
	    $stmt->bindValue(':gender', $this->gender);
	    $stmt->bindValue(":id", $route[1]);
	    $stmt->execute();

	    if($stmt->rowCount() > 0)
	    {
			return $arr_json = array('status' => 200);
	    }else{
			return $arr_json = array('status' => 400);
	    }

	}
	function doDelete($route){
		//DELETE method
		$sql = 'DELETE FROM birimdik.client1 WHERE id = :id';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(":id", $route[1]);
	    $stmt->execute();
	    if($stmt->rowCount() > 0)
	    {
			return $arr_json = array('status' => 200);
	    }else{
			return $arr_json = array('status' => 400);
	    }
	}
}
?>