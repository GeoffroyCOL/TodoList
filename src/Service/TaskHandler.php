<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TaskHandler
{
    private $repository;
    private $manager;
    private $security;

    public function __construct(TaskRepository $repository, EntityManagerInterface $manager, Security $security)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->security = $security;
    }

    /**
     * -----------------------------------------
     * Méthodes de gestion : add / edit / delete
     * -----------------------------------------
     */
    
    /**
     * add - Ajoute une nouvelle tâche
     *
     * @param  Task $task
     * @return void
     */
    public function add(Task $task): void
    {
        $task->setUser($this->security->getUser());
        $this->manager->persist($task);
        $this->manager->flush();
    }
    
    /**
     * edit - Modifie une tâche
     *
     * @param  Task $task
     * @return void
     */
    public function edit(Task $task = null): void
    {
        $this->manager->flush();
    }
    
    /**
     * delete - Supprime une tâche
     *
     * @param  Task $task
     * @return void
     */
    public function delete(Task $task): void
    {
        $this->manager->remove($task);
        $this->manager->flush();
    }

    /**
     * ---------------------------------
     * Méthodes de récupération : getAll
     * ---------------------------------
     */

    /**
     * getAll - Récupère la liste de toutes les tâches / finit ou à faire
     *
     * @param array $data
     * @return Task[]
     */
    public function getAll(array $data): array
    {
        return $this->repository->findBy($data);
    }
}