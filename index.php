<?php
require_once 'app/models/ProductModel.php';

// Lấy URL từ request
$url = $_GET['url'] ?? '';
$url = trim($url);
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra controller name
$controllerName = isset($url[0]) && !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'ProductController';
$controllerFile = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra file controller có tồn tại không
if (!file_exists($controllerFile)) {
    die("Controller '$controllerName' not found in path '$controllerFile'");
}

// Gọi file controller
require_once $controllerFile;

// Kiểm tra class controller có tồn tại không
if (!class_exists($controllerName)) {
    die("Class '$controllerName' not found in '$controllerFile'");
}

// Khởi tạo controller
$controller = new $controllerName();

// Kiểm tra action
$action = isset($url[1]) && !empty($url[1]) ? $url[1] : 'index';
if (!method_exists($controller, $action)) {
    die("Action '$action' not found in controller '$controllerName'");
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
?>
