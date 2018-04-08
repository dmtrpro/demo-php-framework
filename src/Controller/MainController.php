<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 15:04
 */

namespace App\Controller;


use Framework\Controller\HtmlController;
use Psr\Http\Message\ServerRequestInterface;

class MainController extends HtmlController
{
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
        $productSlug = $request->getAttribute('product');

        return $this->render('pages:single', [
            'productName' => $productSlug
        ]);
    }
}