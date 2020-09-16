<?php

namespace Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TaskControllerTest extends WebTestCase
{    
    /**
     * getUserConnect - Simule la connection d'un tutilisateur
     *
     * @param  mixed $client
     */
    private function getUserConnect($client)
    {
        //Récupère un utilisateur
        $user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_1']);

        //On créer d'une session pour contenir l'utilisateur
        $session = $client->getContainer()->get('session');
        $token = new UsernamePasswordToken($user[0], null, 'main', $user[0]->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        //On crée un cookie pour associe l'utilisateur à la session
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    /**
     * ------------
     * Route /tasks
     * ------------
     */

    /**
     * testReturnStatusOK - Test si la page ne retourne pas d'erreur
     */
    public function testReturnStatusOkListTask()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * ------------------
     * Route /task/create
     * ------------------
     */
    
    /**
     * testCreateTask - Test l'ajout d'une nouvelle tâche
     */
    public function testCreateTask()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $crawler = $client->request('GET', '/tasks/create');
        $data = [
            "task[title]"   => "Tâche 13",
            "task[content]" => "Le contenue de la tâche 12",
        ];

        $form = $crawler->selectButton('Ajouter')->form($data);
        $client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
    }

    /**
     * ----------------------
     * Route /tasks/{id}/edit
     * ----------------------
     */

    /**
     * testReturnStatusForEditTaskWithGoodId - Test si la page ne retourne pas d'erreur selon l'id de la tâche
     */
    public function testReturnStatusForEditTaskWithGoodId()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks/6/edit');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testReturnStatusForEditTaskWithBadId - Test si la page retourne une erreur selon l'id de la tâche
     */
    public function testReturnStatusForEditTaskWithBadId()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks/100/edit');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testEditTaskMadeByUser - Si l'utilisateur est l'auteur de la tâche
     */
    public function testEditTaskMadeByUser()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $crawler = $client->request('GET', '/tasks/6/edit');
        $data = [
            "task[title]"   => "Tâche 6 modifiée",
            "task[content]" => "Le contenue de la tâche 6 modifié",
        ];

        $form = $crawler->selectButton('Modifier')->form($data);
        $client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
    }

    /**
     * testEditTaskMadeByUser - Si l'utilisateur n'est pas l'auteur de la tâche
     */
    public function testEditTaskNotMageByUser()
    {
        $client = static::createClient();
        $this->getUserConnect($client);
        $client->request('GET', '/tasks/2/edit');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * ------------------------
     * Route /tasks/{id}/delete
     * ------------------------
     */
    
    /**
     * testReturnStatusForDeleteTaskWitGoodIdNotAuthorize - Test si l'utilisateur peut supprimer une tâche qui ne lui appartient pas
     *
     * @return void
     */
    public function testReturnStatusForDeleteTaskWitGoodIdNotAuthorize()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks/2/delete');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * testReturnStatusForDeleteTaskWitGoodIdAuthorize - Test si l'utilisateur peut supprimer une tâche qui lui appartient
     *
     * @return void
     */
    public function testReturnStatusForDeleteTaskWitGoodIdAuthorize()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks/6/delete');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }


    /**
     * testReturnStatusForDeleteTaskWithBadId - Test si la page retourne une erreur selon l'id de la tâche
     */
    public function testReturnStatusForDeleteTaskWithBadId()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks/100/delete');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    /**
     * ------------------
     * /tasks/{id}/toggle
     * ------------------
     */

    public function testEditTaskToggle()
    {
        $client = static::createClient();
        $this->getUserConnect($client);

        $client->request('GET', '/tasks/2/toggle');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }
}
