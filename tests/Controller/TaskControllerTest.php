<?php

namespace Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Tests\Controller\ControllerTest;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TaskControllerTest extends ControllerTest
{    
    
    /**
     * testCreateTask - Test l'ajout d'une nouvelle tâche
     */
    public function testCreateTask()
    {
        $client = static::createClient();
        $lastTask = self::$container->get(TaskRepository::class)->findOneBy([], ['id' => 'desc'], 1, 0);
        $data = [
            "task[title]"   => "Tâche ".($lastTask->getId()+1),
            "task[content]" => "Le contenue de la tâche",
        ];
        $this->formForGestion($client, '/tasks/create', 'Ajouter', $data, '/tasks');
    }
    
    /**
     * testEditTaskMadeByUser - Si l'utilisateur est l'auteur de la tâche
     */
    public function testEditTaskMadeByUser()
    {
        $client = static::createClient();
        $data = [
            "task[title]"   => "Tâche modifiée",
            "task[content]" => "Le contenue de la tâche 6 modifié",
        ];

        $this->formForGestion($client, '/tasks/11/edit', 'Modifier', $data, '/tasks');
    }

    /**
     * testReturnStatusForDeleteTaskWitGoodIdAuthorize - Test si l'utilisateur peut supprimer une tâche qui lui appartient
     *
     * @return void
     */
    public function testReturnStatusForDeleteTaskWitGoodIdAuthorize()
    {
        $client = static::createClient();
        $lastTask = self::$container->get(TaskRepository::class)->findOneBy([], ['id' => 'desc'],1,0);

        $this->getUserConnect($client, 'user_1');

        $client->request('GET', '/tasks/'.$lastTask->getId().'/delete');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }

    /**
     * testReturnGoodResponse - Teste les données fourni en étant connecté
     * @dataProvider setDataForGoodResponse
     */
    public function testReturnGoodResponse($route, $response)
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $client->request('GET', $route);
        $this->assertEquals($response, $client->getResponse()->getStatusCode());
    }
    
    /**
     * setDataForGoodResponse - Fournit des données pour vérifier différentes routes et avec les status attendu
     *
     * @return void
     */
    public function setDataForGoodResponse()
    {
        return [
            ['/tasks',              Response::HTTP_OK], // Vérifie si la page retourne un status 200
            ['/tasks/11/edit',      Response::HTTP_OK], // Vérifie si la page de la tâche dont l'id est 11 retourne un status 200
            ['/tasks/100/edit',     Response::HTTP_NOT_FOUND], // Vérifie si la page de la tâche dont l'id est 100 retourne un status 404
            ['/tasks/3/edit',       Response::HTTP_FORBIDDEN], // Vérifie le droit d'accès d'un utilisateur selon la tâche pour la modifier 
            ['/tasks/100/delete',   Response::HTTP_NOT_FOUND], // Vérifie que la tâche dont l'id est 100 retourne un status 404 pour cette route
            ['/tasks/3/delete',     Response::HTTP_FORBIDDEN], // Vérifie si l'utilisateur peut supprimer une tâche
            ['/tasks/3/toggle',     Response::HTTP_FOUND] // Vérifie qu'un utilisateur peut choisir de modifier la status d'une tâche
        ];
    }
}
