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

        $client->request('GET', '/tasks');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}