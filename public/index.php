<?php
require '../vendor/autoload.php';

use App\Core\Router;

$response = Router::response();
$render = new \App\Core\Renderer('/../Views');
echo $render->render($response);



