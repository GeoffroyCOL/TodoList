<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler
{
    private $repository;
    private $manager;
    private $encoder;

    public function __construct(UserRepository $repository, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    /**
     * --------------------------------
     * Méthodes de gestion : add / edit
     * --------------------------------
     */
    
    /**
     * add - Ajoute une nouvel utilisateur
     *
     * @param  User $user
     * @return void
     */
    public function add(User $user): void
    {
        $this->password($user);
        $this->manager->persist($user);
        $this->manager->flush();
    }
    
    /**
     * edit - Modifie un utilisateur
     *
     * @param  User $user
     * @return void
     */
    public function edit(User $user): void
    {
        $this->password($user);
        $this->manager->flush();
    }

    /**
     * password - Permet encoder le mot de passe
     *
     * @param  User $user
     */
    private function password(User $user)
    {
        $user->setPassword(
            $this->encoder->encodePassword($user, $user->getPassword())
        );
        $user->eraseCredentials();
    }

    /**
     * ---------------------------------
     * Méthodes de récupération : getAll
     * ---------------------------------
     */

    /**
     * getAll - Récupère la liste de toutes les tâches
     *
     * @return User[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
