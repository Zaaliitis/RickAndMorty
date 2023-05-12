<?php
require '../vendor/autoload.php';
use App\Router;

$response = Router::response();
$render = new \App\Renderer('/../app/Views');
echo $render->render($response);



