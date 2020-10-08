<?php

namespace App\Test\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    /**
     * testReturnNotError - Si la page retourne bien un code 200
     */
    public function testReturnNotErrorPageLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * testLoginWithBadCreadientials - Teste une connexion qui echoue
     * @dataProvider dataForLoginBadCreadientials
     */
    public function testLoginWithBadCreadientials($data)
    {
        $client = static::createClient();
        $this->connect($data, $client);
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testLoginWithGoodCreadientials - Teste une connexion qui réussie
     * @dataProvider dataForLoginGoodCreadientials
     */
    public function testLoginWithGoodCreadientials($data)
    {
        $client = static::createClient();
        $this->connect($data, $client);
        $this->assertResponseRedirects('/');
        $client->followRedirect();
    }
    
    /**
     * connect
     *
     * @param  array $data
     * @param  mixed $client
     */
    private function connect($data, $client)
    {
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form($data);
        $client->submit($form);
    }
    
    /**
     * dataForLoginGoodCreadientials - Fournit des données valides pour la connection
     *
     * @return array
     */
    public function dataForLoginGoodCreadientials(): array
    {
        return [
            [
                [
                    '_username' => 'user_1',
                    '_password' => 'Hum123'
                ]
            ]
        ];
    }
    
    /**
     * dataForLoginBadCreadientials - Fournit des données non valides pour la connection
     *
     * @return array
     */
    public function dataForLoginBadCreadientials(): array
    {
        return [
            [
                [
                    '_username' => 'user_1',
                    '_password' => 'bnvemrjhg'
                ]
            ]
        ];
    }
}
