<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];
	$route = substr($route, 1);
	$route = explode("?", $route);
	$route = explode("/", $route[0]);
	$route = array_diff($route, array('API_Restful', 'ads'));
	$route = array_values($route);

	$arr_json = null;

	if (count($route) <= 3) {
		
		switch ($route[0]) {
			case 'post':
				# code...
				include('post.class.php');
				$post = new Post($_REQUEST['title'],$_REQUEST['avatar'],$_REQUEST['price']);
				$arr_json = $post->verifyMethod($method,$route);
				break;
			case 'posts':
				# code...
				include('posts.class.php');
				$post = new Posts($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['id']);
				$arr_json = $post->verifyMethod($method,$route);
				break;
			default:
				$arr_json = array('status' => 409);
				break;
		}

	}else{
		$arr_json = array('status' => 407);
	}

	echo json_encode($arr_json);

?>