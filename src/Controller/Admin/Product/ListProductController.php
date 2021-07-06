<?php

namespace App\Controller\Admin\Product;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListProductController extends AbstractController {
    /**
     * @Route("admin/produit/liste", name="list_product")
     */
    public function list(ProductRepository $productRepository, Request $request, PaginatorInterface $paginatorInterface) : Response {
        $data = $productRepository->findAll();
        // on part à la page 1 par défaut, sinon le numéro de la page appelée, et on présente 5 produits par page
        $products = $paginatorInterface->paginate($data, $request->query->getInt('page', 1), 5);

        return $this->render('admin/product/list_product.html.twig', ['products' => $products]);
    }
}