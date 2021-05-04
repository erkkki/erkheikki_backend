<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogout(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'test@gmail.com']);

        $client->loginUser($testUser);

        $client->request('GET', '/api/user');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        /** @var string $response */
        $response = $client->getResponse()->getContent();

        $this->assertNotEquals('null', $response);

        /** Logout */
        $client->request('GET', '/logout');

        /** Test if logout was logged out successfully, user should be null */
        $client->request('GET', '/api/user');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $this->assertJson('null', $response);
    }
}
