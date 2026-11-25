<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Controllers/HomeController.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

$router = new Router();


$router->add('GET', '/', [new HomeController(), 'index']);
$router->add('GET', '/test', [new HomeController(), 'test']);

$router->add('GET', '/register', [new AuthController(), 'register']);
$router->add('POST', '/register', [new AuthController(), 'register']);
$router->add('GET', '/login', [new AuthController(), 'login']);
$router->add('POST', '/login', [new AuthController(), 'login']);
$router->add('GET', '/logout', [new AuthController(), 'logout']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $uri);
?>