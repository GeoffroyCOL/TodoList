<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Service\UserHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    private $userHandler;

    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }

    /**
     * listAction - Affiche la liste des utilisateurs
     *
     * @Route("/users", name="user_list")
     *
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->render('user/list.html.twig', [
            'users'         => $this->userHandler->getAll(),
            'current_page'  => 'user'
        ]);
    }

    /**
     * createAction - Créer un nouvel utilisateur
     *
     * @Route("/users/create", name="user_create")
     *
     * @param  Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userHandler->add($form->getDAta());
            $this->addFlash('success', "L'utilisateur a bien été ajouté");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', [
            'form'          => $form->createView(),
            'current_page'  => 'user'
        ]);
    }

    /**
     * editAction - Modifie un utilisateur
     *
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param  User $user
     * @param  Request $request
     * @return Response
     */
    public function editAction(User $user, Request $request): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userHandler->edit($form->getDAta());
            $this->addFlash('success', "L'utilisateur a bien été modifié");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form'          => $form->createView(),
            'user'          => $user,
            'current_page'  => 'user'
        ]);
    }
}
