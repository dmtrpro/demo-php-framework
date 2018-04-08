<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 19:40
 */

namespace Framework\Response;


use Framework\Renderer\RendererInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse as DiactorosJsonResponse;

class ResponseBuilder
{
    /**
     * @var RendererInterface
     */
    protected $renderer;

    /** @var string */
    protected $responseType = 'html';

    /** @var string */
    protected $template;

    /** @var int */
    protected $code;

    /** @var string */
    protected $message;

    /** @var array */
    protected $parameters = [];

    /**
     * @param RendererInterface $renderer
     * @return ResponseBuilder
     */
    public function setRenderer(RendererInterface $renderer): ResponseBuilder
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @param string $responseType
     * @return ResponseBuilder
     */
    public function setResponseType(string $responseType): ResponseBuilder
    {
        $this->responseType = $responseType;
        return $this;
    }

    /**
     * @param string $template
     * @return ResponseBuilder
     */
    public function setTemplate(string $template): ResponseBuilder
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param int $code
     * @return ResponseBuilder
     */
    public function setCode(int $code): ResponseBuilder
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $message
     * @return ResponseBuilder
     */
    public function setMessage(string $message): ResponseBuilder
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $parameters
     * @return ResponseBuilder
     */
    public function setParameters(array $parameters): ResponseBuilder
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters ?: [];
    }

    /**
     * @return RendererInterface
     */
    public function getRenderer(): RendererInterface
    {
        return $this->renderer;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    public function build(array $params = [])
    {
        if (!$params) {
            $params = $this->getParameters();
        }

        switch ($this->getResponseType()){
            case 'json':
                return new JsonResponse($params, $this->getCode(), $this->getMessage());
            case 'json_default':
                return new DiactorosJsonResponse($params);
            default:
                return new HtmlResponse($this->renderer->render($this->getTemplate(), $params));
        }
    }
}