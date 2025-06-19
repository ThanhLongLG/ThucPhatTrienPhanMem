
<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

require_once 'app/controller/ProductApiController.php';
require_once 'app/controller/CategoryApiController.php';

$url = $_GET['url']?? '';
$url = rtrim( $url,'/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/',$url);


$controller = isset($url[0]) && $url[0] != ''? ucfirst($url[0]) .'Controller' : 'DefaultController';


$action = isset($url[1]) && $url[1] != ''? $url[1] : 'index';


// Sửa điều kiện kiểm tra từ 'ApiController' thành 'api'
if (isset($url[0]) && $url[0] === 'api') {
   $apiControllerName = ucfirst($url[1] ?? '') . 'ApiController'; // Ví dụ: ProductApiController
   if (file_exists('app/controller/' . $apiControllerName . '.php')) {
       require_once 'app/controller/' . $apiControllerName . '.php';
       $controller = new $apiControllerName();
       $method = $_SERVER['REQUEST_METHOD'];
       $id = $url[2] ?? null;

       switch ($method) {
           case 'GET':    $action = $id ? 'show' : 'index'; break;
           case 'POST':   $action = 'store'; break;
           case 'PUT':    $action = $id ? 'update' : 'index'; break;
           case 'DELETE': $action = $id ? 'destroy' : 'index'; break;
           default:
               http_response_code(405);
               die(json_encode(['error' => 'Method Not Allowed']));
       }
   } else {
       die('API Controller not found');
   }
}


if(!file_exists('app/controller/'.$controller.'.php')){
   die('Controller not found');
}


require_once 'app/controller/'.$controller.'.php';

$controller = new $controller();

if(!method_exists($controller, $action)){
   die('Method not found');
}


call_user_func_array([$controller, $action], array_slice($url, 2));

