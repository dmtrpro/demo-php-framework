<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 20:31
 */

namespace Framework\Controller;


use Framework\Renderer\RendererInterface;
use Framework\Response\ResponseBuilder;

class ResponseBuilderController
{
    /**
     * @var ResponseBuilder
     */
    protected $response;

    /**
     * ResponseBuilderController constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->response = new ResponseBuilder();
        $this->response->setRenderer($renderer);
    }

    /**
     * @return ResponseBuilder
     */
    public function getResponse(): ResponseBuilder
    {
        return $this->response;
    }

    /**
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendResponse(array $params = [])
    {
        return $this->response->build($params);
    }

    /**
     * @param string $template
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function render(string $template, array $params = [])
    {
        $this->response->setTemplate($template);

        return $this->response->build($params);
    }
}