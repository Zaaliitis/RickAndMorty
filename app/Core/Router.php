<?php
namespace App\Core;

class Router
{
    public static function response(): ?View
    {
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', [\App\Controllers\Controller::class, "home"]);
            $r->addRoute('GET', '/search', [\App\Controllers\Controller::class, "search"]);
            $r->addRoute('GET', '/character', [\App\Controllers\Controller::class, "character"]);
            $r->addRoute('GET', '/home', [\App\Controllers\Controller::class, "home"]);
            $r->addRoute('GET', '/location', [\App\Controllers\Controller::class, "location"]);
            $r->addRoute('GET', '/episode', [\App\Controllers\Controller::class, "episode"]);
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                return null;

            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                return null;

            case \FastRoute\Dispatcher::FOUND:
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