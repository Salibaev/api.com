<?php
include('connection/connection.class.php');
/**
* Client class verify what method was sent and execute the respective method.
*/
class Put_users
{
	//Attributes
	private $id;
	private $login;
	private $password;
	private $avatar;
	private $numbers;
	private $name;
	private $surname;
	private $city;
	private $user_id;
	private $image_name;
	private $db;
	private $method;
	function __construct($login = '', $password = '', $avatar = '',$numbers = '',$name = '',$surname = '',$city = '',$user_id = '',$image_name = '')
	{
		# Construct the class and set the values in the attributes.
		$this->db = ConnectionDB::getInstance();
		$this->login = $login;
		$this->password = $password;
		$this->avatar = $avatar;
		$this->numbers = $numbers;
		$this->name = $name;
		$this->surname = $surname;
		$this->city = $city;
		$this->user_id = $user_id;
		$this->image_name = $image_name;
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
		$sql = "SELECT * FROM users ";
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':login', $this->login);
	    $stmt->bindValue(':password', $this->password);
	    $stmt->bindValue(':avatar', $this->avatar);
	    $stmt->bindValue(':numbers', $this->numbers);
	    $stmt->bindValue(':name', $this->name);
	    $stmt->bindValue(':surname', $this->surname);
	    $stmt->bindValue(':city', $this->city);
	    $stmt->execute();

	    if($stmt->rowCount() > 0)
	    {
	    	header('Access-Control-Allow-Origin: *');
	    	header("Access-Control-Allow-Headers: *");
	    	$row  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $arr_json = array('status' => 200, 'registr' => $row);
	    }else{
			return $arr_json = array('status' => 405);
	    }
	}
	function doPost(){
		//POST method
		$sql = 'UPDATE birimdik.users 
						SET 
						login = :login,
						password = :password, 
						avatar = :avatar,
						numbers = :numbers,
						name = :name,
						surname = :surname,
						city = :city
						WHERE id = :user_id';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':login', $this->login);
	    $stmt->bindValue(':password', $this->password);
	    $stmt->bindValue(':avatar', $this->avatar['name']);
	    $stmt->bindValue(':numbers', $this->numbers);
	    $stmt->bindValue(':name', $this->name);
	    $stmt->bindValue(':surname', $this->surname);
	    $stmt->bindValue(':city', $this->city);
	    $stmt->bindValue(':user_id', $this->user_id);
	    // $stmt->bindValue(':image_name', $this->image_name);
	    


	   
	    $stmt->bindValue(':avatar',$this->avatar['name']);
	    array_map('unlink', glob("uploads/".$this->image_name));
	    $target_dir = "uploads/";
		$target_file = $target_dir . basename($this->avatar["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($this->avatar["tmp_name"]);
		  if($check !== false) {
		    echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($target_file)) {
		  echo "Sorry, file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($this->avatar["size"] > 5000000) {
		  echo "Sorry, your file is too large.";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		  if (move_uploaded_file($this->avatar["tmp_name"], $target_file)) {
		    // echo "The file ". htmlspecialchars( basename( $this->avatar["name"])). " has been uploaded.";
		  } else {
		    echo "Sorry, there was an error uploading your file.";
		  }
		}
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