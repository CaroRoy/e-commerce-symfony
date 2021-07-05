<?php

namespace App\Controller\Admin\Category;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditCategoryController extends AbstractController {
    /**
     * @Route("admin/categorie/edit/{id}", name="edit_category")
     */
    public function edit(int $id, Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository) {
        $category = $categoryRepository->find($id);

        if (!$category) {
            $this->addFlash('danger', 'Cette catégorie n\'exsite pas');
            return $this->redirectToRoute('list_category');
        }

        $imageOriginal = $category->getImageUrl();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imageUrl')->getData();

            if ($image !== null) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('app_images_directory'), $file);

                $category->setImageUrl('/uploads/' . $file);

                // SUPPRESSION DE L'IMAGE D'ORIGINE DU DOSSIER UPLOADS
                // si on a bien un résultat stocké dans $imageOriginal (donc si on a bien une image originale)
                if ($imageOriginal !== null) {
                    // on stocke le chemin qui va au fichier de l'image dans $fileImageOriginal
                    $fileImageOriginal = $this->getParameter('app_images_directory') . '/..' . $imageOriginal;

                    if (file_exists($fileImageOriginal)) {
                        // on supprime du dossier uploads l'image d'origine (avant modif) s'il y en avait une :
                        unlink($fileImageOriginal);
                    }
                }
            }

            $em->flush();

            $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été modifiée');
            return $this->redirectToRoute('list_category');
        }

        return $this->render('admin/category/edit_category.html.twig', ['formCategory' => $form->createView()]);
    }
}