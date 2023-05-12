<?php
namespace App\Core;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
    public static function response(array $routes): ?View
    {
        $dispatcher = simpleDispatcher(function (\FastRoute\RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                [$httpMethod, $url, $handler] = $route;
                $r->addRoute($httpMethod, $url, $handler);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return null;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                return null;

            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $class = new $handler[0]();
                $method = $handler[1];
                /** @var View $response */
                $response = $class->$method();

                return $response;

        }
return null;
    }
}