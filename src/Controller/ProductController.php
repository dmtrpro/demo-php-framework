<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 20:16
 */

namespace App\Controller;


use Framework\Controller\ResponseBuilderController;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends ResponseBuilderController
{
    public function indexAction(ServerRequestInterface $request)
    {
        $query = $request->getQueryParams();

        return $this->render('pages:products');
    }
}
