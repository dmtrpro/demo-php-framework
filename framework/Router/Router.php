<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 17:16
 */

namespace Framework\Router;


use Framework\Router\Exception\InvalidRequestException;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    protected $routes = [];

    public function match(ServerRequestInterface $request): Route
    {
        foreach ($this->routes as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new InvalidRequestException($request, 'Page not found!');
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function get($name, $path, $callable): Route
    {
        $route = new Route($name, $path, $callable);
        $route->setMethods(['GET']);

        $this->addRoute($route);

        return $route;
    }

    public function post($name, $path, $callable): Route
    {
        $route = new Route($name, $path, $callable);
        $route->setMethods(['POST']);

        $this->addRoute($route);

        return $route;
    }
}