<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];
	$route = substr($route, 1);
	$route = explode("?", $route);
	$route = explode("/", $route[0]);
	$route = array_diff($route, array('API_Restful', 'birimdik'));
	$route = array_values($route);

	$arr_json = null;

	if (count($route) <= 3) {
		
		switch ($route[0]) {
			case 'client1':
				# code...
				include('client1.class.php');
				$client1 = new Client1($_REQUEST['location'],$_REQUEST['descriptions'],$_REQUEST['categories'],$_FILES['images'],$_REQUEST['price'],$_REQUEST['numbers'],$_FILES['image1'],$_FILES['image2'],$_FILES['image3'],$_FILES['image4'],$_FILES['image5'],$_FILES['image6'],$_REQUEST['recommend'],$_REQUEST['currency'],$_REQUEST['userid'],$_REQUEST['city']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'iz_status2':
				# code...
				include('iz_status2.class.php');
				$client1 = new Iz_status2($_REQUEST['status'],$_REQUEST['ad_id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'update1':
				# code...
				include('update1.class.php');
				$client1 = new Update1($_REQUEST['location'],$_REQUEST['descriptions'],$_REQUEST['categories'],$_FILES['images'],$_REQUEST['price'],$_REQUEST['numbers'],$_FILES['image1'],$_FILES['image2'],$_FILES['image3'],$_FILES['image4'],$_FILES['image5'],$_FILES['image6'],$_REQUEST['recommend'],$_REQUEST['currency'],$_REQUEST['userid'],$_REQUEST['city'],$_REQUEST['ad_id'],$_REQUEST['image_name']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'update2':
				# code...
				include('update2.class.php');
				$client1 = new Update2($_REQUEST['location'],$_REQUEST['descriptions'],$_REQUEST['categories'],$_REQUEST['images'],$_REQUEST['price'],$_REQUEST['numbers'],$_REQUEST['image1'],$_REQUEST['image2'],$_REQUEST['image3'],$_REQUEST['image4'],$_REQUEST['image5'],$_REQUEST['image6'],$_REQUEST['recommend'],$_REQUEST['currency'],$_REQUEST['userid'],$_REQUEST['city']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'get_favorites':
				# code...
				include('get_favorites.class.php');
				$favorites = new Get_favorites($_REQUEST['user_id']);
				$arr_json = $favorites->verifyMethod($method,$route);
				break;
				case 'users1':
				# code...
				include('users1.class.php');
				$users = new Users1($_REQUEST['id']);
				$arr_json = $users->verifyMethod($method,$route);
				break;
				case 'my_ad':
				# code...
				include('my_ad.class.php');
				$client1 = new My_ad($_REQUEST['id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'favorites':
				# code...
				include('favorites.class.php');
				$favorites = new Favorites($_REQUEST['ad_id'],$_REQUEST['user_id']);
				$arr_json = $favorites->verifyMethod($method,$route);
				break;
				case 'neaktiv':
				# code...
				include('neaktiv.class.php');
				$client1 = new Neaktiv($_REQUEST['user_id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'favorite':
				# code...
				include('favorite.class.php');
				$favorites = new Favorite($_REQUEST['ad_id'],$_REQUEST['user_id']);
				$arr_json = $favorites->verifyMethod($method,$route);
				break;
				case 'delete_favorites':
				# code...
				include('delete_favorites.class.php');
				$favorites = new Delete_favorites($_REQUEST['ad_id'],$_REQUEST['user_id']);
				$arr_json = $favorites->verifyMethod($method,$route);
				break;
				case 'delete_ad':
				# code...
				include('delete_ad.class.php');
				$client1 = new Delete_ad($_REQUEST['ad_id'],$_REQUEST['user_id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'users':
				# code...
				include('getusers.class.php');
				$users = new Getusers($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['avatar'],$_REQUEST['numbers']);
				$arr_json = $users->verifyMethod($method,$route);
				break;
				case 'registr':
				# code...
				include('registr.class.php');
				$users = new Registr($_REQUEST['login'],$_REQUEST['password'],$_FILES['avatar'],$_REQUEST['numbers'],$_REQUEST['name'],$_REQUEST['surname'],$_REQUEST['city']);
				$arr_json = $users->verifyMethod($method,$route);
				break;
				case 'put_users':
				# code...
				include('put_users.class.php');
				$users = new Put_users($_REQUEST['login'],$_REQUEST['password'],$_FILES['avatar'],$_REQUEST['numbers'],$_REQUEST['name'],$_REQUEST['surname'],$_REQUEST['city'],$_REQUEST['user_id'],$_REQUEST['image_name']);
				$arr_json = $users->verifyMethod($method,$route);
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
				case 'search':
				# code...
				include('search.class.php');
				$client1 = new Search($_REQUEST['id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'filter_city':
				# code...
				include('filter_city.class.php');
				$client1 = new Filter_city($_REQUEST['id'],$_REQUEST['id2']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'postcategory':
				# code...
				include('getcategory.class.php');
				$category = new Getcategory($_REQUEST['id']);
				$arr_json = $category->verifyMethod($method,$route);
				break;
			case 'rekom':
				# code...
				include('rekom.class.php');
				$client1 = new Rekom($_REQUEST['id']);
				$arr_json = $client1->verifyMethod($method,$route);
				break;
				case 'location':
				# code...
				include('location.class.php');
				$location = new Location($_REQUEST['id']);
				$arr_json = $location->verifyMethod($method,$route);
				break;
				case 'post_ad':
				# code...
				include('post_ad.class.php');
				$category = new Post_ad($_REQUEST['id']);
				$arr_json = $category->verifyMethod($method,$route);
				break;
				case 'category':
				# code...
				include('idcategory.class.php');
				$category = new Idcategory($_REQUEST['id']);
				$arr_json = $category->verifyMethod($method,$route);
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