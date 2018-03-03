<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 14:17
 */

namespace Framework;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\SapiEmitter;

class Kernel implements RequestHandlerInterface
{
    protected $container;
    protected $middleware = [];

    /**
     * Kernel constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middleware)) {
            return $this->container->get('DefaultHandler')->handle($request);
        }

        $middleware = array_shift($this->middleware);
        return $middleware->process($request, $this);
    }

    /**
     * @param ResponseInterface $response
     */
    public function emit(ResponseInterface $response)
    {
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param MiddlewareInterface|string $middleware
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function add($middleware)
    {
        if (is_string($middleware)) {
            $middleware = $this->container->get($middleware);
        }

        if ($middleware instanceof MiddlewareInterface) {
            $this->middleware[] = $middleware;
        } else {
            throw new \InvalidArgumentException('Argument must be instance of MiddlewareInterface');
        }
    }
}