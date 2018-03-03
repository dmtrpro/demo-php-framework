<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 23:07
 */

namespace Framework\Authorization;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AuthorizationMapInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isAuthorized(ServerRequestInterface $request): bool;

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function needsAuthorization(ServerRequestInterface $request): bool;

    /**
     * @return ResponseInterface
     */
    public function prepareUnauthorizedResponse(): ResponseInterface;

    /**
     * @param ResponseInterface $response
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function signResponse(ResponseInterface $response, ServerRequestInterface $request): ResponseInterface;
}