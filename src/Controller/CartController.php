<?php

namespace App\Controller;

use App\MesServices\CartServices\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController {
    // l'id doit forcément être un nombre positif (requirements)
    /**
     * @Route("cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function add(int $id, CartService $cartService, ProductRepository $productRepository, Request $request) {
        $product = $productRepository->find($id);

        if (!$product) {
            $this->addFlash('warning', 'Produit inconnu');
            return $this->redirectToRoute('public_home');
        }
        
        $cartService->add($id);

        $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été ajouté au panier');

        if ($request->query->get('returnToCart')) {
            return $this->redirectToRoute('cart_show');
        }

        return $this->redirectToRoute('show_product', ['slug' => $product->getSlug()]);
    }

    /**
     * @Route("cart/show", name="cart_show")
     */
    public function show(CartService $cartService) {
        $detailedCart = $cartService->show();

        $total = $cartService->getTotal();

        return $this->render('public/cart.html.twig', ['detailedCart' => $detailedCart, 'total' => $total]);
    }

    /**
     * @Route("cart/decrement/{id}", name="cart_decrement", requirements={"id":"\d+"})
     */
    public function decrement(int $id, CartService $cartService, ProductRepository $productRepository) {
        $product = $productRepository->find($id);

        if (!$product) {
            $this->addFlash('warning', 'Produit inconnu');
            return $this->redirectToRoute('public_home');
        }
        
        $cartService->decrement($id);

        $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été retiré du panier');
        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("cart/remove/{id}", name="cart_remove")
     */
    public function remove(int $id, CartService $cartService, ProductRepository $productRepository) {
        $product = $productRepository->find($id);

        if (!$product) {
            $this->addFlash('warning', 'Produit inconnu');
            return $this->redirectToRoute('public_home');
        }

        $cartService->remove($id);

        return $this->redirectToRoute('cart_show');
    }
}