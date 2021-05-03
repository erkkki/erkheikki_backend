<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/user');
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();


        $data = json_decode($response->getBody(true), true);
    }

    public function testSomething(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'test@gmail.com']);

        $client->loginUser($testUser);

        $client->request('GET', '/api/user');
        $this->assertResponseIsSuccessful();
    }
}
