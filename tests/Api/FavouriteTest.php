<?php

namespace App\Tests\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FavouriteTest extends WebTestCase
{
    public function testUserNotLoggedIn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/favourite_stations');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        /* What is should be */
        $this->assertEquals("/api/contexts/FavouriteStation", $responseArray['@context']);
        $this->assertEquals("/api/favourite_stations", $responseArray['@id']);
        $this->assertEquals("hydra:Collection", $responseArray['@type']);

        /** Should not contain any stations. */
        $this->assertEquals(0, $responseArray['hydra:totalItems']);
    }

    public function testUserHasZeroFavorites(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'second_test@gmail.com']);

        $client->loginUser($testUser);

        $client->request('GET', '/api/favourite_stations');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();

        $responseArray = json_decode($response, true);


        /* What is should be */
        $this->assertEquals("/api/contexts/FavouriteStation", $responseArray['@context']);
        $this->assertEquals("/api/favourite_stations", $responseArray['@id']);
        $this->assertEquals("hydra:Collection", $responseArray['@type']);

        /** Should not contain any stations. */
        $this->assertEquals(0, $responseArray['hydra:totalItems']);
    }


    public function testGetUserFavorites(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'test@gmail.com']);

        $client->loginUser($testUser);

        $client->request('GET', '/api/favourite_stations');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();

        $responseArray = json_decode($response, true);

        /* What is should be */
        $this->assertEquals("/api/contexts/FavouriteStation", $responseArray['@context']);
        $this->assertEquals("/api/favourite_stations", $responseArray['@id']);
        $this->assertEquals("hydra:Collection", $responseArray['@type']);

        /** Should only contain 4 stations. */
        $this->assertEquals(4, $responseArray['hydra:totalItems']);


        foreach ($responseArray['hydra:member'] as &$station) {
            $this->assertArrayHasKey('stationuuid', $station);
            $this->assertArrayHasKey('name', $station);
            $this->assertArrayHasKey('createdAt', $station);
        }
    }
}
