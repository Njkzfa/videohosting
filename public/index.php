<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Controllers/HomeController.php';

use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();

$router->add('GET', '/', [new HomeController(), 'index']);
$router->add('GET', '/test', [new HomeController(), 'test']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $uri);
?>