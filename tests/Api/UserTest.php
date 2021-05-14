<?php

namespace App\Tests\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testUserNotLoggedIn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/user');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $this->assertEquals('null', $response);
    }

    public function testUserLoggedIn(): void
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
        $responseUser = json_decode($response, true);


        $this->assertArrayHasKey("id", $responseUser);
        $this->assertArrayHasKey("email", $responseUser);
        $this->assertArrayHasKey("username", $responseUser);

        $this->assertArrayNotHasKey("roles", $responseUser);
        $this->assertArrayNotHasKey("password", $responseUser);
        $this->assertArrayNotHasKey("salt", $responseUser);
        $this->assertArrayNotHasKey("googleId", $responseUser);

        $this->assertEquals("test@gmail.com", $responseUser["email"]);
    }
}
