<?php

namespace Framework\Router\Exception;

use Psr\Http\Message\ServerRequestInterface;

class InvalidRequestException extends \LogicException
{
    private $request;

    public function __construct(ServerRequestInterface $request, string $message = 'Invalid request', int $code = 0)
    {
        parent::__construct($message, $code);
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
