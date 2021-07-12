<?php

namespace App\Controller\Admin\Product;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowProductController extends AbstractController {

    /**
     * @Route("/produit/details/{slug}", name="show_product")
     */
    public function showProduct(ProductRepository $productRepository, string $slug) : Response {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        if (!$product) {
            $this->addFlash('warning', 'Produit inconnu');
            return $this->redirectToRoute('public_home');
        }

        $category = $product->getCategory();

        $productsAssociate = [];

        if ($category) {
            $productsAssociate = $productRepository->findProductToPropose($product);
        }


        return $this->render('public/product/show_product.html.twig', ['product' => $product, 'productsAssociate' => $productsAssociate]);
    }
}
