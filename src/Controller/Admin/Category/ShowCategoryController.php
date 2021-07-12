<?php

namespace App\Controller\Admin\Category;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShowCategoryController extends AbstractController{
    /**
     * @Route("categorie/details/{slug}", name="show_category_products")
     */
    public function show(string $slug, CategoryRepository $categoryRepository) : Response {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            $this->addFlash('warning','Catégorie inconnue');
            return $this->redirectToRoute('public_home');
        }

        return $this->render('public/category/categorie.html.twig', ['category' => $category]);
    }
}