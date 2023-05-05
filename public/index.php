<?php
require '../vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Router;

$loader = new FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new Environment($loader);

$response = Router::response();
echo $twig->render($response->getPath() . '.html.twig', $response->getData());


