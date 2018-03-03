<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 22:54
 */

namespace Framework\Middleware;


use Framework\Authorization\AuthorizationMapInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private $authorizationMap;

    public function __construct(AuthorizationMapInterface $authorizationMap)
    {
        $this->authorizationMap = $authorizationMap;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorizationMap = $this->authorizationMap;

        if (!$authorizationMap->needsAuthorization($request)) {
            return $handler->handle($request);
        }

        if (!$authorizationMap->isAuthorized($request)) {
            return $authorizationMap->prepareUnauthorizedResponse();
        }

        $response = $handler->handle($request);
        return $authorizationMap->signResponse($response, $request);
    }
}

