<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 18:16
 */

namespace Framework\Controller;


use Framework\Renderer\RendererInterface;
use Zend\Diactoros\Response\HtmlResponse;

abstract class HtmlController
{
    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * HtmlController constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param string $template
     * @param array $params
     * @return HtmlResponse
     */
    protected function render(string $template, array $params = [])
    {
        return new HtmlResponse($this->renderer->render($template, $params));
    }
}