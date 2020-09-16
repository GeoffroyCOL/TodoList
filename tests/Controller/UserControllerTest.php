<?php

namespace App\Test\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Test\TraitUserConnectTest;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
    /**
     * getUserConnect - Simule la connection d'un tutilisateur
     *
     * @param  mixed $client
     */
    private function getUserConnect($client, $user)
    {
        //Récupère un utilisateur
        //$user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_1']);

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
     * Route /users
     * ------------
     */
    
    /**
     * testReturnListUsersNotAuthorize - Test le refus d'accéder à la page qui liste les utilisateurs
     */
    public function testReturnListUsersNotAuthorize()
    {
        $client = static::createClient();
        $user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_2']);
        $this->getUserConnect($client, $user);

        $client->request('GET', '/users');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testReturnListUsersAuthorize - Test sur l'autorisation d'accéder à la page qui liste les utilisateurs ( ROLE_ADMIN )
     */
    public function testReturnListUsersAuthorize()
    {
        $client = static::createClient();
        $user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_1']);
        $this->getUserConnect($client, $user);

        $client->request('GET', '/users');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * -------------------
     * Route /users/create
     * -------------------
     */
    
    /**
     * testCreateUserWithRoleAdmin - Test si un utilisateur avec un ROLE_ADMIN peut ajouter un urilisateur
     */
    public function testCreateUserWithRoleAdmin()
    {
        $client = static::createClient();
        $user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_1']);
        $this->getUserConnect($client, $user);

        $crawler = $client->request('GET', '/users/create');

        $data = [
            "user[username]"            => "user_8",
            "user[email]"               => "user_8@gmail.com",
            "user[password][first]"     => "Hum123",
            "user[password][second]"    => "Hum123",
            "user[roles]"               => "ROLE_USER"
        ];

        $form = $crawler->selectButton('Ajouter')->form($data);
        $client->submit($form);
        $this->assertResponseRedirects('/users');
        $client->followRedirect();
    } 

    /**
     * testCreateUserWithRoleAdmin - Test si un utilisateur qui ne possède pas le rôle ROLE_ADMIN peut ajouter un urilisateur
     */
    public function testCreateUserWithOutRoleAdmin()
    {
        $client = static::createClient();
        $user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_2']);
        $this->getUserConnect($client, $user);

        $crawler = $client->request('GET', '/users/create');

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * ----------------------
     * Route /users/{id}/edit
     * ----------------------
     */
    
    /**
     * testEditUserWithRoleAdmin - Test si un utilisateur avec un rôle adlin peut modifier un utilisateur
     */
    public function testEditUserWithRoleAdmin()
    {
        $client = static::createClient();
        $user = self::$container->get(UserRepository::class)->findBy(['username' => 'user_1']);
        $this->getUserConnect($client, $user);

        $crawler = $client->request('GET', '/users/17/edit');

        $data = [
            "user_edit[username]"  => "user_222 modifié"
        ];

        $form = $crawler->selectButton('Modifier')->form($data);
        $client->submit($form);
        $this->assertResponseRedirects('/users');
        $client->followRedirect();
    } 
}