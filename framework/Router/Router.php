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
    /**
     * @var Route[]
     */
    protected $routes = [];

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new InvalidRequestException($request, 'Page not found!');
    }

    public function generate(string $name, array $params = []): string
    {
        foreach ($this->routes as $route) {
            if (null !== $url = $route->generate($name, array_filter($params))) {
                return $url;
            }
        }

        throw new \InvalidArgumentException('Cannot create route "'.$name.'"!');
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

    public function put($name, $path, $callable): Route
    {
        $route = new Route($name, $path, $callable);
        $route->setMethods(['PUT']);

        $this->addRoute($route);

        return $route;
    }

    public function delete($name, $path, $callable): Route
    {
        $route = new Route($name, $path, $callable);
        $route->setMethods(['DELETE']);

        $this->addRoute($route);

        return $route;
    }

    public function patch($name, $path, $callable): Route
    {
        $route = new Route($name, $path, $callable);
        $route->setMethods(['PATCH']);

        $this->addRoute($route);

        return $route;
    }

    public function map(array $methods, $name, $path, $callable): Route
    {
        $route = new Route($name, $path, $callable);
        $route->setMethods($methods);

        $this->addRoute($route);

        return $route;
    }
}