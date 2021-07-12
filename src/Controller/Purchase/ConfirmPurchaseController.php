<?php

namespace App\Controller\Purchase;

use DateTime;
use App\Entity\User;
use App\Entity\Purchase;
use App\Entity\LinePurchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\MesServices\CartServices\CartService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfirmPurchaseController extends AbstractController {
    /**
     * @Route("purchase/confirm", name="purchase_confirm")
     */
    public function confirm(CartService $cartService, EntityManagerInterface $em, MailerInterface $mailer) {
        $purchase = new Purchase();
        $purchase->setDate(new DateTime());
        $purchase->setCustomer($this->getUser());
        $purchase->setTotal($cartService->getTotal());

        $em->persist($purchase);

        $arrayLines = [];

        $detailedCart = $cartService->show();
        foreach ($detailedCart as $item) {
            $linePurchase = new LinePurchase();
            $linePurchase->setProduct($item['product']);
            $linePurchase->setQuantity($item['qty']);
            $linePurchase->setTotal($item['product']->getPrice() * $item['qty']);
            $linePurchase->setPurchase($purchase);

            $arrayLines[] = $linePurchase;
            $em->persist($linePurchase);
        }

        $em->flush();

        /**@var User $user */
        $user = $this->getUser();
        //envoi d'un email :
        $email = new TemplatedEmail();
        $email->to($user->getEmail())
        ->from('contact@cafe-eshop.fr')
        ->subject('Nouvelle commande')
        ->htmlTemplate('email/purchase_confirm.html.twig')
        ->context(['purchase' => $purchase, 'lines' => $arrayLines]);

        $mailer->send($email);

        $cartService->empty();

        $this->addFlash('success','Commande confirmée');
        return $this->redirectToRoute('cart_show');
    }
}