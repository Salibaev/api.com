<?php
include('connection/connection.class.php');
/**
* Client class verify what method was sent and execute the respective method.
*/
class Delete_ad
{
	//Attributes
	private $ad_id;
	private $user_id;
	private $db;
	private $method;
	function __construct( $ad_id = '', $user_id = '')
	{
		# Construct the class and set the values in the attributes.
		$this->db = ConnectionDB::getInstance();
		$this->ad_id = $ad_id;
		$this->user_id = $user_id;

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
		$sql = 'INSERT birimdik.favorites (ad_id,user_id) VALUES (:ad_id,:user_id)';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':id', $this->ad_id);
	    $stmt->bindValue(':user_id', $this->user_id);
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
		header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: *");
		//DELETE method
		$sql = 'DELETE FROM birimdik.client1 WHERE id = :ad_id AND userid = :user_id';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':ad_id', $this->ad_id);
	    $stmt->bindValue(':user_id', $this->user_id);
	    $stmt->execute();
	    if($stmt->rowCount() > 0)
	    {	
	    	header('Access-Control-Allow-Origin: *');
	    	header("Access-Control-Allow-Headers: *");

			return $arr_json = array('status' => 200);
	    }else{
			return $arr_json = array('status' => 400);
	    }
	}
}
?>