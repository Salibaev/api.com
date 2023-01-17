<?php
include('connection/connection.class.php');
/**
* Client class verify what method was sent and execute the respective method.
*/
// function cors() {
    
//     // Allow from any origin
//     if (isset($_SERVER['HTTP_ORIGIN'])) {
//         // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
//         // you want to allow, and if so:
//         header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//         header('Access-Control-Allow-Credentials: true');
//         header('Access-Control-Max-Age: 86400');    // cache for 1 day
//     }
    
//     // Access-Control headers are received during OPTIONS requests
//     if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
//         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
//             // may also be using PUT, PATCH, HEAD etc
//             header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
//         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
//             header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
//         exit(0);
//     }
    
//     echo "You have CORS!";
// }
class Clients
{
	//Attributes
	private $id;
	private $login;
	private $password;
	private $db;
	private $method;
	private $userid;
	function __construct($login = '', $password = '',$userid = '')
	{
		# Construct the class and set the values in the attributes.
		$this->db = ConnectionDB::getInstance();
		$this->login = $login;
		$this->password = $password;
		$this->userid = $userid;	
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
		$sql = 'SELECT * FROM api.client WHERE id=:id';
	    $stmt = $this->db->prepare($sql);
	    // $stmt->bindValue("users", $route[1]);
		$stmt->bindValue(":id", $this->userid);    
	    $stmt->execute();
	    if($stmt->rowCount() > 0)
	    {
	    	$row  = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    	header('Access-Control-Allow-Origin: *');
			return $arr_json = array('status' => 200, 'clients' => $row);
	    }else{
			return $arr_json = array('status' => 404);
	    }
	}
	function doPost(){
		//POST method
		$sql = 'SELECT * FROM api.client WHERE name=:login AND password=:password';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(':login', $this->login);
	    $stmt->bindValue(':password', $this->password);
	    $stmt->execute();
	    if($stmt->rowCount() > 0)
	    {	
	    	$row  = $stmt->fetch(PDO::FETCH_ASSOC);
	    	header('Access-Control-Allow-Origin: *');
			return $arr_json = array('status' => 200,'user' =>$row);
	    }else{
			return $arr_json = array('status' => 400);
	    }
		
	}
	function doPut($route){
		//PUT method
		$sql = 'UPDATE api.client 
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
		$sql = 'DELETE FROM api.client WHERE id = :id';
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