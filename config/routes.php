<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/ProductController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/OrderController.php';
require_once __DIR__ . '/../app/Controllers/FileController.php';

use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\FileController;


// Définition des routes
$routes = [
    '/inscription' => ['GET', [AuthController::class, 'showRegisterForm']],
    '/register' => ['POST', [AuthController::class, 'register']],
    '/connexion' => ['GET', [AuthController::class, 'showLoginForm']],
    '/login' => ['POST', [AuthController::class, 'login']],
    '/logout' => ['POST', [AuthController::class, 'logout']],
    '/' => ['GET', [HomeController::class, 'showHomePage']],
    '/monstock' => ['GET', [ProductController::class, 'showStockPage']],
    '/add_product' => ['GET', [ProductController::class, 'addProduct']],
    '/storage/{filename}' => ['GET', [FileController::class, 'serveFile']],
    '/product' => ['GET', [ProductController::class, 'showProductPage']],
    '/products/delete' => ['POST', [ProductController::class, 'deleteProduct']],
    '/products/update' => ['POST', [ProductController::class, 'updateProduct']],
    '/order' => ['POST', [OrderController::class, 'createOrder']],
    '/mescommandes' => ['GET', [OrderController::class, 'showMyOrdersPage']],
    '/commandes_recues' => ['GET', [OrderController::class, 'showOrdersPage']],
    '/order/processing' => ['POST', [OrderController::class, 'processOrder']],
    '/order/completed' => ['POST', [OrderController::class, 'completeOrder']],

];

// Traitement de la requête
$route = strtok($_SERVER['REQUEST_URI'], '?');

if (array_key_exists($route, $routes)) {
    $method = $routes[$route][0];
    $controllerAction = $routes[$route][1];
    $controller = new $controllerAction[0]();
    $action = $controllerAction[1];
    $controller->$action();
} else {
    echo "404 - Page not found";
}
