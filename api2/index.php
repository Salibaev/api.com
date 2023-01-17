<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];
	$route = substr($route, 1);
	$route = explode("?", $route);
	$route = explode("/", $route[0]);
	$route = array_diff($route, array('API_Restful', 'api2'));
	$route = array_values($route);

	$arr_json = null;

	if (count($route) <= 3) {
		
		switch ($route[0]) {
			case 'client1':
				# code...
				include('client1.class.php');
				$client1 = new Client1($_REQUEST['name'],$_REQUEST['age'],$_REQUEST['gender'],$_REQUEST['avatar']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
			case 'clients':
				# code...
				include('clients.class.php');
				$client1 = new Clients($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
			case 'post':
				# code...
				include('getpoid.class.php');
				$client1 = new Getpoid($_REQUEST['id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
			default:
				$arr_json = array('status' => 401);
				break;
		}

	}else{
		$arr_json = array('status' => 404);
	}

	echo json_encode($arr_json);

?>