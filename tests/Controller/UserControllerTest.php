<?php

namespace App\Test\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Test\TraitUserConnectTest;
use Tests\Controller\ControllerTest;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends ControllerTest
{

    /**
     * testReturnListUsersNotAuthorize - Test le refus d'accéder à la page qui liste les utilisateurs
     */
    public function testReturnListUsersNotAuthorize()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_3');

        $client->request('GET', '/users');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testReturnListUsersAuthorize - Test sur l'autorisation d'accéder à la page qui liste les utilisateurs ( ROLE_ADMIN )
     */
    public function testReturnListUsersAuthorize()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');

        $client->request('GET', '/users');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testCreateUserWithRoleAdmin - Test si un utilisateur avec un ROLE_ADMIN peut ajouter un urilisateur
     */
    public function testCreateUserWithRoleAdmin()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');
        $lastUser = self::$container->get(UserRepository::class)->findOneBy([], ['id' => 'desc'], 1, 0);

        $data = [
            "user[username]"            => "user_".($lastUser->getId()+1),
            "user[email]"               => "user_".($lastUser->getId()+1)."@gmail.com",
            "user[password][first]"     => "Hum123",
            "user[password][second]"    => "Hum123",
            "user[roles]"               => "ROLE_USER"
        ];

        $this->formForGestion($client, '/users/create', 'Ajouter', $data, '/users');
    } 

    /**
     * testCreateUserWithRoleAdmin - Test si un utilisateur qui ne possède pas le rôle ROLE_ADMIN peut ajouter un urilisateur
     */
    public function testCreateUserWithOutRoleAdmin()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_3');

        $client->request('GET', '/users/create');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * testEditUserWithRoleAdmin - Test si un utilisateur avec un rôle adlin peut modifier un utilisateur
     */
    public function testEditUserWithRoleAdmin()
    {
        $client = static::createClient();
        $this->getUserConnect($client, 'user_1');
        $data = [
            "user_edit[username]"               => "user_222 modifié",
            "user_edit[newPassword][first]"     => "Hum123",
            "user_edit[newPassword][second]"    => "Hum123",
        ];

        $this->formForGestion($client, '/users/17/edit', 'Modifier', $data, '/users');
    }
}