<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 15:04
 */

namespace App\Controller;


use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class MainController
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function indexAction(ServerRequestInterface $request)
    {
        return $this->render('pages:index');
    }

    public function cartAction(ServerRequestInterface $request)
    {
        return $this->render('pages:cart');
    }

    public function checkoutAction(ServerRequestInterface $request)
    {
        return $this->render('pages:checkout');
    }

    public function catalogAction(ServerRequestInterface $request)
    {
        return $this->render('pages:products');
    }

    public function singleAction(ServerRequestInterface $request)
    {
        $arguments = $request->getAttribute('args');

        $productSlug = $arguments['product'];

        return $this->render('pages:single', [
            'productName' => $productSlug
        ]);
    }

    private function render(string $template, array $params = [])
    {
        return new HtmlResponse($this->renderer->render($template, $params));
    }
}