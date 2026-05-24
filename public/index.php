<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

use App\Controllers\AdminController;
use App\Controllers\AiController;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\HelpController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\ProductController;
use App\Router;

$route = $_GET['route'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$router = new Router();

$router->get('home', [HomeController::class, 'index']);

$router->get('login', [AuthController::class, 'loginForm']);
$router->post('login', [AuthController::class, 'login']);
$router->get('register', [AuthController::class, 'registerForm']);
$router->post('register', [AuthController::class, 'register']);
$router->get('logout', [AuthController::class, 'logout']);

$router->get('products.index', [ProductController::class, 'index']);
$router->get('products.show', [ProductController::class, 'show']);
$router->get('products.create', [ProductController::class, 'createForm']);
$router->post('products.create', [ProductController::class, 'create']);
$router->get('products.edit', [ProductController::class, 'editForm']);
$router->post('products.update', [ProductController::class, 'update']);
$router->post('products.delete', [ProductController::class, 'delete']);

$router->get('cart.index', [CartController::class, 'index']);
$router->post('cart.add', [CartController::class, 'add']);
$router->post('cart.update', [CartController::class, 'update']);
$router->get('cart.clear', [CartController::class, 'clear']);

$router->get('orders.index', [OrderController::class, 'index']);
$router->get('orders.show', [OrderController::class, 'show']);
$router->post('orders.checkout', [OrderController::class, 'checkout']);
$router->post('orders.updateStatus', [OrderController::class, 'updateStatus']);

$router->get('help.index', [HelpController::class, 'index']);
$router->post('help.ask', [HelpController::class, 'ask']);

$router->post('ai.suggestDescription', [AiController::class, 'suggestDescription']);
$router->post('ai.logAcceptance', [AiController::class, 'logAcceptance']);

$router->get('admin.activity', [AdminController::class, 'activityLog']);
$router->get('admin.aiLog', [AdminController::class, 'aiLog']);

$router->dispatch($route, $method);
