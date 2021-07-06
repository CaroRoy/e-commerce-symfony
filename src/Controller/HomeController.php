<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
    /**
     * @Route("/", name="public_home")
     */
    public function home(ProductRepository $productRepository,CategoryRepository $categoryRepository): Response {
        $categoryVedette = $categoryRepository->findBy([]);

        $products = $productRepository->findBy([
            'category' => $categoryVedette,
        ],[],12);

        $categories = $categoryRepository->findBy([],[],3);


        return $this->render('public/home.html.twig',[
            'products'=> $products,
            'categories' => $categories
        ]);
    }
}