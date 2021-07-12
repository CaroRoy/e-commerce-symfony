<?php

namespace App\Controller\Purchase;

use App\MesServices\CartServices\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecapPurchaseController extends AbstractController {
    /**
     * @Route("/purchase/recap", name="purchase_recap")
     */
    public function recap(CartService $cartService) {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning','Pour finaliser votre commande, merci de créer un compte');
            return $this->redirectToRoute('app_register');
        }

        $detailedCart = $cartService->show();

        if (count($detailedCart) === 0) {
            $this->addFlash('warning','Pas de facture : aucun produit dans le panier');
            return $this->redirectToRoute('cart_show');
        }

        $total = $cartService->getTotal();

        return $this->render('public/purchase/recap.html.twig', ['detailedCart' => $detailedCart, 'total' => $total, 'user' => $user]);
    }
}