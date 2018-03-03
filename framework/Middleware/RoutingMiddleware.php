<?php

namespace Framework\Middleware;

use Framework\Router\Exception\InvalidRequestException;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoutingMiddleware implements MiddlewareInterface
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container, Router $router)
    {
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $route = $this->router->match($request);

            $callable = $this->checkCallable($route->getCallable());

            $args = $route->getArguments();

            $response = call_user_func_array($callable, [$request->withAttribute('args', $args)]);

            if (!$response instanceof ResponseInterface) {
                throw new \RuntimeException(
                    'Route callables must return an instance of (Psr\Http\Message\ResponseInterface)'
                );
            }

            return $response;
        } catch (InvalidRequestException $e) {
            return $handler->handle($request);
        }
    }

    /**
     * @param $callable
     * @return array|string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function checkCallable($callable)
    {
        if (is_string($callable) && strpos($callable, '::') !== false) {
            $callable = explode('::', $callable);
        }

        if (is_array($callable) && isset($callable[0]) && is_object($callable[0])) {
            $callable = [$callable[0], $callable[1]];
        }

        if (is_array($callable) && isset($callable[0]) && is_string($callable[0])) {
            $class = ($this->container->has($callable[0]))
                ? $this->container->get($callable[0])
                : new $callable[0];

            $callable = [$class, $callable[1]];
        }

        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('Could not resolve a callable for this route');
        }

        return $callable;
    }
}