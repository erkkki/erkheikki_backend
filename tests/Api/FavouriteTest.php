<?php

namespace App\Tests\Api;

use App\Repository\FavouriteStationRepository;
use App\Repository\UserRepository;
use http\Client;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
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

    public function testAddNewNeedLogin(): void
    {
        $client = static::createClient();

        $newFavStation = ['name' => 'test', 'stationuuid' => 'testuuid'];
        $this->jsonRequest($client, 'POST', $newFavStation);

        $this->assertResponseRedirects('/login');
    }

    public function testAddNew(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'second_test@gmail.com']);

        $newFavStation = ['name' => 'test', 'stationuuid' => 'testuuid'];

        $client->loginUser($testUser);

        $this->jsonRequest($client, 'POST', $newFavStation);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);


        /** Should now return 1 fav station */
        $client->request('GET', '/api/favourite_stations');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);
        $this->assertEquals(1, $responseArray['hydra:totalItems']);
    }

    public function testMissingParameter(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'second_test@gmail.com']);
        $client->loginUser($testUser);

        $newFavStation = ['name' => 'test'];

        $this->jsonRequest($client, 'POST', $newFavStation);
        $this->assertResponseStatusCodeSame(422);
    }


    public function testDeleteNotLoggedIn(): void
    {
        $client = static::createClient();

        /** @var FavouriteStationRepository $favRepository */
        $favRepository = static::$container->get(FavouriteStationRepository::class);
        $station = $favRepository->findOneBy(['stationuuid' => 'testuuid']);

        $client->request('DELETE', '/api/favourite_stations/' . $station->getId());

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDelete(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'second_test@gmail.com']);
        $client->loginUser($testUser);

        /** @var FavouriteStationRepository $favRepository */
        $favRepository = static::$container->get(FavouriteStationRepository::class);
        $station = $favRepository->findOneBy(['stationuuid' => 'testuuid']);

        $client->request('DELETE', '/api/favourite_stations/' . $station->getId());

        $this->assertResponseIsSuccessful();
    }

    private function jsonRequest(KernelBrowser $client, string $method, array $content): void
    {
        $content = json_encode($content);

        if (!$content) {
            $content = null;
        }

        $client->request(
            $method,
            '/api/favourite_stations',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );
    }
}
