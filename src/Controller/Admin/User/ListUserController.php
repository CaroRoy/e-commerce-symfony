<?php

namespace App\Controller\Admin\User;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListUserController extends AbstractController {
    /**
     * @Route("admin/utilisateur/liste", name="list_user")
     */
    public function list(UserRepository $userRepository, Request $request, PaginatorInterface $paginatorInterface) : Response {
        $data = $userRepository->findAll();
        // on part à la page 1 par défaut, sinon le numéro de la page appelée, et on présente 5 produits par page
        $users = $paginatorInterface->paginate($data, $request->query->getInt('page', 1), 5);

        return $this->render('admin/user/list_user.html.twig', ['users' => $users]);
    }
}