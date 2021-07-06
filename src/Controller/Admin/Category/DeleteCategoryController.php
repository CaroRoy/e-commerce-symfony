<?php

namespace App\Controller\Admin\Category;

use App\MesServices\ImageServices\DeleteImageService;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteCategoryController extends AbstractController {
    /**
     * @Route("admin/categorie/supprimer/{id}", name="delete_category")
     */
    public function delete(int $id, CategoryRepository $categoryRepository, EntityManagerInterface $em, DeleteImageService $deleteImageService) : RedirectResponse {
        $category = $categoryRepository->find($id);

        if (!$category) {
            $this->addFlash('danger', 'Cette catégorie n\'existe pas');
            return $this->redirectToRoute('list_category');
        }

        // Processus de suppression de l'image associée sans Service :
        // if ($category->getImageUrl() !== null) {
        //     $fileImageOriginal = $this->getParameter('app_images_directory') . '/..' . $category->getImageUrl();

        //     if (file_exists($fileImageOriginal)) {
        //         unlink($fileImageOriginal);
        //     }
        // }
        
        // Processus de suppression de l'image avec Service DeleteImageService
        $deleteImageService->deleteImage($category->getImageUrl(), $this->getParameter('app_images_directory'));

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été supprimée');
        return $this->redirectToRoute('list_category');
    }
}