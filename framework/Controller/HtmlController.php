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
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    protected function render(string $template, array $params = [])
    {
        return new HtmlResponse($this->renderer->render($template, $params));
    }
}