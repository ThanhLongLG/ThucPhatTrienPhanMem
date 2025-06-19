<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

// 1. Xử lý URL
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 2. Phân biệt API vs Non-API routes
if (isset($url[0]) && $url[0] === 'api') {
    // API Route
    $apiControllerName = ucfirst($url[1] ?? '') . 'ApiController';
    $apiControllerFile = 'app/controller/' . $apiControllerName . '.php';

    if (!file_exists($apiControllerFile)) {
        die(json_encode(['error' => 'API Controller not found']));
    }

    require_once $apiControllerFile;
    $controller = new $apiControllerName();

    // Xác định phương thức HTTP
    $method = $_SERVER['REQUEST_METHOD'];
    $id = $url[2] ?? null;

    // Ánh xạ phương thức
    $action = match ($method) {
        'GET'    => $id ? 'show' : 'index',
        'POST'   => 'store',
        'PUT'    => $id ? 'update' : 'index',
        'DELETE' => $id ? 'destroy' : 'index',
        default  => null
    };

    if (!$action || !method_exists($controller, $action)) {
        http_response_code(405);
        die(json_encode(['error' => 'Method Not Allowed']));
    }

    // Gọi API controller
    call_user_func_array([$controller, $action], $id ? [$id] : []);
    exit;
}

// 3. Non-API Route (MVC thông thường)
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$controllerFile = 'app/controller/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    die('Controller not found');
}

require_once $controllerFile;
$controller = new $controllerName();
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

if (!method_exists($controller, $action)) {
    die('Method not found');
}

// Gọi non-API controller
call_user_func_array([$controller, $action], array_slice($url, 2));
