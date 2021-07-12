<?php

namespace App\MesServices\CartServices;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository) {
        $this->session = $session; 
        $this->productRepository = $productRepository;   
    }

    public function add(int $id) {
        // on récupère le panier 'cart' depuis la session ou s'il n'existe pas, on en crée un avec un tableau vide :
        $cart = $this->getCart();

        if (!array_key_exists($id, $cart)) {
            $cart[$id] = 0;
        }

        $cart[$id]++;
        $this->saveCart($cart);
    }

    public function decrement(int $id) {
        $cart = $this->getCart();

        if (!array_key_exists($id, $cart)) {
            return;
        }

        if ($cart[$id] === 1) {
            // si on a une quantité de 1 pour cet id, alors on supprime le produit de la liste du panier
            $this->remove($id);
            return;
        }

        $cart[$id]--;
        $this->saveCart($cart);
    }

    public function remove($id) {
        $cart = $this->getCart();
        unset($cart[$id]);
        $this->saveCart($cart);
    }

    public function show() : array {
        $detailedCart = [];
        $cart = $this->getCart();

        // on récupère le panier qu'on a créé dans la fonction add juste au-dessus
        // chaque élément du panier correspond à un id assicié à une valeur $qty
        foreach($cart as $id => $qty) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $detailedCart[] = ['product' => $product, 'qty' => $qty];
        }

        return $detailedCart;
    }

    public function getTotal() : int {
        $total = 0;
        $cart = $this->getCart();

        foreach ($cart as $id => $qty) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $total += $product->getPrice() * $qty;
        }

        return $total;
    }

    public function getCart() {
        return $this->session->get('cart', []);
    }

    public function saveCart($cart) {
        $this->session->set('cart', $cart);
    }

    public function empty() {
        $this->saveCart([]);
    }
}