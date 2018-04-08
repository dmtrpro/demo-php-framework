<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 22:30
 */

namespace Framework\Middleware;


use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * ErrorHandlerMiddleware constructor.
     *
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            $debug = CONFIG['global']['debug'];

            $template = ($debug) ? 'error/debug' : 'error/error';

            return new HtmlResponse('<pre>'.json_encode([
                'exception' => $e,
                'code' => 500,
                'message' => 'Internal Server Error',
                'description' => 'Error #' . $e->getCode() . ': ' . $e->getMessage()
            ]).'</pre>', 500);
        }
    }
}