<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskHandler
{
    private $repository;
    private $manager;

    public function __construct(TaskRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
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
        $this->manager->persist($task);
        $this->manager->flush();
    }
    
    /**
     * edit - Modifie une tâche
     *
     * @param  Task $task
     * @return void
     */
    public function edit(Task $task): void
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
     * getAll - Récupère la liste de toutes les tâches
     *
     * @return Task[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}