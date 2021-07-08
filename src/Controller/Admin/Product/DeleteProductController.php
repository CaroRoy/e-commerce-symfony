<?php

namespace App\Controller\Admin\Product;

use App\MesServices\ImageServices\DeleteImageService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteProductController extends AbstractController {

    /**
     * @Route("/admin/produit/supprimer/{id}", name="delete_product")
     */
    public function delete(int $id, EntityManagerInterface $em, ProductRepository $productRepository, DeleteImageService $deleteImageService) : RedirectResponse {
        $product = $productRepository->find($id);

        if (!$product) {
            $this->addFlash('danger', 'Ce produit n\'existe pas');
            return $this->redirectToRoute('list_product');
        }

        // Processus de suppression de l'image associée sans Service :
        // if ($product->getImageUrl() !== null) {
        //     $fileImageOriginal = $this->getParameter('app_images_directory') . '/..' . $product->getImageUrl();

        //     if (file_exists($fileImageOriginal)) {
        //         unlink($fileImageOriginal);
        //     }
        // }

        // Processus de suppression de l'image avec Service DeleteImageService
        $deleteImageService->deleteImage($product->getImageUrl());
        
        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été supprimé');

        return $this->redirectToRoute('list_product');
    }
}
