<?php

namespace App\Controller\Admin\Product;

use App\Form\ProductType;
use App\MesServices\ImageServices\DeleteImageService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProductController extends AbstractController {
    /**
     * @Route("admin/produit/modifier/{id}", name="edit_product")
     */
    public function edit(int $id, Request $request, EntityManagerInterface $em, ProductRepository $productRepository, DeleteImageService $deleteImageService) {
        $product = $productRepository->find($id);

        if (!$product) {
            $this->addFlash('danger', 'Ce produit n\'exsite pas');
            return $this->redirectToRoute('list_product');
        }

        // on stocke l'image pour pouvoir la supprimer si on a une nouvelle image dans le formulaire
        $imageOriginal = $product->getImageUrl();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imageUrl')->getData();

            if ($image !== null) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('app_images_directory'), $file);

                $product->setImageUrl('/uploads/' . $file);

                // SUPPRESSION DE L'IMAGE D'ORIGINE DU DOSSIER UPLOADS (sans Service)
                // si on a bien un résultat stocké dans $imageOriginal (donc si on a bien une image originale)
                // if ($imageOriginal !== null) {
                //     // on stocke le chemin qui va au fichier de l'image dans $fileImageOriginal
                //     $fileImageOriginal = $this->getParameter('app_images_directory') . '/..' . $imageOriginal;

                //     if (file_exists($fileImageOriginal)) {
                //         // on supprime du dossier uploads l'image d'origine (avant modif) s'il y en avait une :
                //         unlink($fileImageOriginal);
                //     }
                // }

                // Suppression de l'image avec Service DeleteImageService :
                $deleteImageService->deleteImage($imageOriginal, $this->getParameter('app_images_directory'));
            }

            $em->flush();

            $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été modifié');
            return $this->redirectToRoute('list_product');
        }

        return $this->render('admin/product/edit_product.html.twig', ['formProduct' => $form->createView()]);
    }
}