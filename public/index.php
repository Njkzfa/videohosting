<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/Models/Video.php';
require_once __DIR__ . '/../src/Controllers/VideoController.php';
require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Controllers/HomeController.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/VideoController.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\VideoController;
use App\Models\Video;

$router = new Router();

$router->add('GET', '/test', [new HomeController(), 'test']);

$router->add('GET', '/register', [new AuthController(), 'register']);
$router->add('POST', '/register', [new AuthController(), 'register']);
$router->add('GET', '/login', [new AuthController(), 'login']);
$router->add('POST', '/login', [new AuthController(), 'login']);
$router->add('GET', '/logout', [new AuthController(), 'logout']);

$router->add('GET', '/', function() {
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }
    $videoModel = new \App\Models\Video();
    $videos = $videoModel->getAll();
    require __DIR__ . '/../views/home.php';
});

$router->add('GET', '/upload', [new VideoController(), 'uploadForm']);
$router->add('POST', '/upload', [new VideoController(), 'upload']);
$router->add('GET', '/stream', [new VideoController(), 'stream']);


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $uri);
?>