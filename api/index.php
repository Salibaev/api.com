<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];
	$route = substr($route, 1);
	$route = explode("?", $route);
	$route = explode("/", $route[0]);
	$route = array_diff($route, array('API_Restful', 'api'));
	$route = array_values($route);

	$arr_json = null;

	if (count($route) <= 3) {
		
		switch ($route[0]) {
			case 'client':
				# code...
				include('client.class.php');
				$client = new Client($_REQUEST['name'],$_REQUEST['age'],$_REQUEST['gender'],$_FILES['image']);
				$arr_json = $client->verifyMethod($method,$route);
				break;
			case 'clients':
				# code...
				include('clients.class.php');
				$client = new Clients($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['id']);
				$arr_json = $client->verifyMethod($method,$route);
				break;
			default:
				$arr_json = array('status' => 404);
				break;
		}

	}else{
		$arr_json = array('status' => 404);
	}

	echo json_encode($arr_json);

?>