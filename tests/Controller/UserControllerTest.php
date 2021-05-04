<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    /** User should be null */
    public function testUserNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/user');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $this->assertJson('null', $response);
    }

    /** Should return user */
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

        $this->assertArrayHasKey("uuid", $responseUser);
        $this->assertArrayHasKey("email", $responseUser);
        $this->assertArrayHasKey("username", $responseUser);

        $this->assertArrayNotHasKey("id", $responseUser);
        $this->assertArrayNotHasKey("roles", $responseUser);
        $this->assertArrayNotHasKey("password", $responseUser);
        $this->assertArrayNotHasKey("salt", $responseUser);
        $this->assertArrayNotHasKey("googleId", $responseUser);

        $this->assertEquals("test@gmail.com", $responseUser["email"]);
    }
}
