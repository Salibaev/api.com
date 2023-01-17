<?php
include('connection/connection.class.php');
/**
* Client class verify what method was sent and execute the respective method.
*/
class Client1
{
	//Attributes
	private $id;
	private $location;
	private $descriptions;
	private $categories;
	private $images;
	private $price;
	private $numbers;
	private $image1;
	private $image2;
	private $image3;
	private $image4;
	private $image5;
	private $image6;
	private $recommend;
	private $currency;
	private $userid;
	private $city;
	private $db;
	private $method;
	function __construct($location = '', $descriptions = '', $categories = '',$images = '', $price = '', $numbers = '',$image1 = '',$image2 = '',$image3 = '',$image4 = '',$image5 = '',$image6 = '',$recommend = '',$currency = '',$userid = '',$city = '')
	{
		# Construct the class and set the values in the attributes.
		$this->db = ConnectionDB::getInstance();
		$this->location = $location;
		$this->descriptions = $descriptions;
		$this->categories = $categories;
		$this->images = $images;
		$this->price = $price;
		$this->numbers = $numbers;
		$this->image1 = $image1;
		$this->image2 = $image2;
		$this->image3 = $image3;
		$this->image4 = $image4;
		$this->image5 = $image5;
		$this->image6 = $image6;
		$this->recommend = $recommend;
		$this->currency = $currency;
		$this->userid = $userid;
		$this->city = $city;

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
		$sql = 'SELECT * FROM client1 WHERE status = 1';
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
		header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: *");
		//POST method
		$sql = 'INSERT birimdik.client1 (location,descriptions,categories,images,price,numbers,image1,image2,image3,image4,image5,image6,recommend,currency,userid,city) VALUES (:location,:descriptions,:categories,:images,:price,:numbers,:image1,:image2,:image3,:image4,:image5,:image6,:recommend,:currency,:userid,:city)';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':location', $this->location);
	    $stmt->bindValue(':descriptions', $this->descriptions);
	    $stmt->bindValue(':categories', $this->categories);
	    $stmt->bindValue(':images', $this->images['name']);
	    $stmt->bindValue(':price', $this->price);
	    $stmt->bindValue(':numbers', $this->numbers);
	    $stmt->bindValue(':image1', $this->image1['name']);
	    $stmt->bindValue(':image2', $this->image2['name']);
	    $stmt->bindValue(':image3', $this->image3['name']);
	  	$stmt->bindValue(':image4', $this->image4['name']);
	  	$stmt->bindValue(':image5', $this->image5['name']);
	  	$stmt->bindValue(':image6', $this->image6['name']);
	  	$stmt->bindValue(':recommend', $this->recommend);
	  	$stmt->bindValue(':currency', $this->currency);
	  	$stmt->bindValue(':userid', $this->userid);
	  	$stmt->bindValue(':city', $this->city);
	    // $stmt->bindValue(':image',$this->image['name']);
	    $target_dir = "uploads/";
		$target_file = $target_dir . basename($this->images["name"]);
		$target_file1 = $target_dir . basename($this->image1["name"]);
		$target_file2 = $target_dir . basename($this->image2["name"]);
		$target_file3 = $target_dir . basename($this->image3["name"]);
		$target_file4 = $target_dir . basename($this->image4["name"]);
		$target_file5 = $target_dir . basename($this->image5["name"]);
		$target_file6 = $target_dir . basename($this->image6["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
		$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
		$imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
		$imageFileType4 = strtolower(pathinfo($target_file4,PATHINFO_EXTENSION));
		$imageFileType5 = strtolower(pathinfo($target_file5,PATHINFO_EXTENSION));
		$imageFileType6 = strtolower(pathinfo($target_file6,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($this->images["tmp_name"]);
		   $check1 = getimagesize($this->image1["tmp_name"]);
		   $check2 = getimagesize($this->image2["tmp_name"]);
		   $check3 = getimagesize($this->image3["tmp_name"]);
		   $check4 = getimagesize($this->image4["tmp_name"]);
		   $check5 = getimagesize($this->image5["tmp_name"]);
		   $check6 = getimagesize($this->image6["tmp_name"]);
		  if($check !== false 
		  	AND $check1 !== false 
		  	AND $check2  !== false 
		  	AND $check3  !== false 
		  	AND $check4  !== false
		  	AND $check5  !== false
		  	AND $check6  !== false ) {
		    echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($target_file AND $target_file1 AND $target_file2 AND $target_file3 AND $target_file4 AND $target_file5 AND $target_file6)) {
		  echo "Sorry, file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($this->images["size"] > 5000000
		 AND $this->image1["size"] > 5000000
		 AND $this->image2["size"] > 5000000
		 AND $this->image3["size"] > 5000000
		 AND $this->image4["size"] > 5000000
		 AND $this->image5["size"] > 5000000
		 AND $this->image6["size"] > 5000000
		) {
		  echo "Sorry, your file is too large.";
		  $uploadOk = 0;
		}

		// // Allow certain file formats
		// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		// && $imageFileType != "gif" ) {
		//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		//   $uploadOk = 0;
		// }

		if( $imageFileType AND $imageFileType1 AND $imageFileType2 AND $imageFileType3 AND $imageFileType4 AND $imageFileType5 AND $imageFileType6 != "jpg"
		&&	$imageFileType AND $imageFileType1 AND $imageFileType2 AND $imageFileType3 AND $imageFileType4 AND $imageFileType5 AND $imageFileType6 != "png" 
		&&  $imageFileType AND $imageFileType1 AND $imageFileType2 AND $imageFileType3 AND $imageFileType4 AND $imageFileType5 AND $imageFileType6 != "jpeg"
		&&  $imageFileType AND $imageFileType1 AND $imageFileType2 AND $imageFileType3 AND $imageFileType4 AND $imageFileType5 AND $imageFileType6 != "gif" ) {
		  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		  if (move_uploaded_file($this->images["tmp_name"], $target_file)
		   AND move_uploaded_file($this->image1["tmp_name"], $target_file1)
		   AND move_uploaded_file($this->image2["tmp_name"], $target_file2)
		   AND move_uploaded_file($this->image3["tmp_name"], $target_file3)
		   AND move_uploaded_file($this->image4["tmp_name"], $target_file4)
		   AND move_uploaded_file($this->image5["tmp_name"], $target_file5)
		   AND move_uploaded_file($this->image6["tmp_name"], $target_file6)
		) {
		    // echo "The file ". htmlspecialchars( basename( $this->images["name"])). " has been uploaded.";
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