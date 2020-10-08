<?php

namespace App\Test\Controller;

use Tests\Controller\ControllerTest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class DefaultControllerTest extends ControllerTest
{   
    /**
     * testAccessHomePage - Test si un utilisateur connecté peut accéder a cette page
     *
     * @return void
     */
    public function testAccessHomePage()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testClickCreateNewTask - Test si le lien vers la page de création d'une tâche fonctionne
     */
    public function testClickCreateNewTask()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton('Ajouter')->form();
        $this->assertNotEmpty($form);
    }

    /**
     * testClicklistNewTaskNotOver - Test si le lien vers la page de liste des tâche a réalisées
     */
    public function testClicklistNewTaskNotOver()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = trim(preg_replace('/\s\s+/', ' ', $info));

        $this->assertSame("Liste des tâches à réaliser", $info);
    }

    /**
     * testClicklistNewTaskOver - Test si le lien vers la page de création d'une tâche terminées
     */
    public function testClicklistNewTaskOver()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Consulter la liste des tâches terminées')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = trim(preg_replace('/\s\s+/', ' ', $info));

        $this->assertSame("Liste des tâches terminées", $info);
    }

    public function testClickCreateUserRoleAdmin()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = trim(preg_replace('/\s\s+/', ' ', $info));

        $this->assertSame("Créer un utilisateur", $info);
    }
}