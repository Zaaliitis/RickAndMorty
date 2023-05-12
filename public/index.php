<?php
require '../vendor/autoload.php';

use App\Core\Router;
$routes = require_once '../routes.php';
$response = Router::response($routes);
$render = new \App\Core\Renderer('/../Views');
echo $render->render($response);



