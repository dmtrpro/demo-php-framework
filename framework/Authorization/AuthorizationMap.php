<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 22:57
 */

namespace Framework\Authorization;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class AuthorizationMap implements AuthorizationMapInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isAuthorized(ServerRequestInterface $request): bool
    {
        return false;
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function needsAuthorization(ServerRequestInterface $request): bool
    {
        return false;
    }

    /**
     * @return ResponseInterface
     */
    public function prepareUnauthorizedResponse(): ResponseInterface
    {
        return new HtmlResponse('401 Access denied!', 200);
    }

    /**
     * @param ResponseInterface $response
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function signResponse(ResponseInterface $response, ServerRequestInterface $request): ResponseInterface
    {
        // Do something with response.

        return $response;
    }
}