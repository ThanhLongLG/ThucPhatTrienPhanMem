
<?php
$url = $_GET['url']?? '';
$url = rtrim( $url,'/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/',$url);


$controller = isset($url[0]) && $url[0] != ''? ucfirst($url[0]) .'Controller' : 'DefaultController';


$action = isset($url[1]) && $url[1] != ''? $url[1] : 'index';

if(!file_exists('app/controller/'.$controller.'.php')){
   die('Controller not found');
}


require_once 'app/controller/'.$controller.'.php';

$controller = new $controller();

if(!method_exists($controller, $action)){
   die('Method not found');
}


call_user_func_array([$controller, $action], array_slice($url, 2));

