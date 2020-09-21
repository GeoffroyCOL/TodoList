<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TaskController extends AbstractController
{
    private $taskHandler;

    public function __construct(TaskHandler $taskHandler)
    {
        $this->taskHandler = $taskHandler;
    }

    /**
     * listAction - Affiche la liste des tâches selon son status ( A faire ou terminée )
     * 
     * @Route("/tasks", name="task_list")
     * 
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $status = false;
        $status_tache = " à réaliser";

        if ($request->query->get('status') == 'over') {
            $status = true;
            $status_tache = " terminées";
        }

        return $this->render('task/list.html.twig', [
            'tasks' => $this->taskHandler->getAll(['isDone' => $status]),
            'status_tache' => $status_tache
        ]);
    }

    /**
     * createAction - Créer une nouvelle tâche
     * 
     * @Route("/tasks/create", name="task_create")
     * 
     * @param  Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskHandler->add($form->getData());
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * editAction - Modifie une tâche
     * 
     * @Route("/tasks/{id}/edit", name="task_edit")
     * 
     * @param  Task $task
     * @param  Request $request
     * @return Response
     */    
    public function editAction(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task, 'Vous ne pouvez pas modifier cette tâche');

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskHandler->edit($form->getData());
            $this->addFlash('success', 'La tâche a bien été modifiée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * toggleTaskAction - Permet de modifier le status de la tâche : A faire ou réalisée
     * 
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * 
     * @param  Task $task
     * @return Response
     */
    public function toggleTaskAction(Task $task): Response
    {
        $task->toggle(!$task->isDone());

        $this->taskHandler->edit($task);
        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * deleteTaskAction - Permet de supprimer une tâche
     * 
     * @Route("/tasks/{id}/delete", name="task_delete")
     * 
     * @param  Task $task
     * @return Response
     */
    public function deleteTaskAction(Task $task): Response
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task, 'Vous ne pouvez pas supprimer cette tâche');

        $this->taskHandler->delete($task);
        $this->addFlash('success', 'La tâche a bien été supprimée');

        return $this->redirectToRoute('task_list');
    }
}
