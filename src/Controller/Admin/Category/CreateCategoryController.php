<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateCategoryController extends AbstractController {
    /**
     * @Route("admin/categorie/creer",name="create_category")
     */
    public function create(Request $request, EntityManagerInterface $em) : Response {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // pour faciliter l'écriture avec l'autocomplétion de VSCode, on indique que $category appartient à la class Category :
            /** @var Category $category */
            $category = $form->getData();

            // on récupère l'image :
            $image = $form->get('imageUrl')->getData();

            // on vérifie que l'image existe bien :
            if ($image !== null) {
                // on crée un nom pour l'image avec une extension
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                // on déplace l'image dans le dossier uploads, avec son nouveau nom $file
                $image->move($this->getParameter('app_images_directory'), $file);

                // on attribut cette image $file qui se trouve dans le dossier uploads, pour la category $category
                $category->setImageUrl('/uploads/' . $file);
            }

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie '. $category->getName() . ' a bien été créée');

            return $this->redirectToRoute('list_category');
        }

        return $this->render('admin/category/create_category.html.twig', ['formCategory' => $form->createView()]);
    }
}