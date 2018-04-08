<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 20:16
 */

namespace App\Controller;


use App\App;
use App\Repository\ProductRepository;
use Framework\Controller\ResponseBuilderController;
use Framework\DB\Database;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends ResponseBuilderController
{
    /**
     * @var ProductRepository
     */
    protected $repository;

    public function __construct(RendererInterface $renderer, ProductRepository $productRepository)
    {
        parent::__construct($renderer);
        $this->repository = $productRepository;
    }

    public function indexAction(ServerRequestInterface $request)
    {
        global $container;

        $query = $request->getQueryParams();

        $limit = (int) $query['limit'] ?? 6;
        $page = (int) $query['page'] ?? 1;

//        $this->repository->findAll([
//            'limit' => $limit,
//            'offset' => $limit*($page-1)
//        ]);

       // $this->response->setResponseType($request->getAttribute('type', 'html'));
        return $this->render('pages:products');
    }
}
