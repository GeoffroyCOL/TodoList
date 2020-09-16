<?php

namespace Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


abstract class ControllerTest extends WebTestCase
{    
    /**
     * getUserConnect - Simule l'authentification d'un utilisateur
     *
     * @param  mixed $client
     * @param  string $username
     * @return void
     */
    protected function getUserConnect($client, string $username)
    {
        $user = self::$container->get(UserRepository::class)->findOneBy(['username' => $username]);

        //On créer d'une session pour contenir l'utilisateur
        $session = $client->getContainer()->get('session');
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        //On crée un cookie pour associe l'utilisateur à la session
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    /**
     * formForGestion
     *
     * @param  mixed $client
     * @param  string $route
     * @param  string $action
     * @param  array $data
     * @param  string $redirection
     */
    public function formForGestion($client, $route, $action, $data, $redirection)
    {
        $this->getUserConnect($client, 'user_1');
        $crawler = $client->request('GET', $route);
        $form = $crawler->selectButton($action)->form($data);
        $client->submit($form);
        $this->assertResponseRedirects($redirection);
        $client->followRedirect();
    }
}