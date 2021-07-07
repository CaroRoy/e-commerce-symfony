<?php

namespace App\Controller\Admin\User;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowUserController extends AbstractController {

    /**
     * @Route("/admin/utilisateur/details/{id}", name="show_user")
     */
    public function showUser(UserRepository $userRepository, int $id) : Response {
        $user = $userRepository->find($id);
        return $this->render('admin/user/show_user.html.twig', ['user' => $user]);
    }
}
