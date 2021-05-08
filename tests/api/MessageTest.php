<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MessageTest extends ApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAddNew(): void
    {
        $response = static::createClient()->request('POST', '/api/messages', ['json' => [
            'message' => 'Post test message',
            'color' => '#ffff11',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Message',
            'message' => 'Post test message',
            'color' => '#ffff11',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSpaceInEnd(): void
    {
        $response = static::createClient()->request('POST', '/api/messages', ['json' => [
            'message' => 'Test Space in End ',
            'color' => '#ffff11',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Message',
            'message' => 'Test Space in End ',
            'color' => '#ffff11',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testEmoticon(): void
    {
        $response = static::createClient()->request('POST', '/api/messages', ['json' => [
            'message' => 'Test emoticon 😀😀😀',
            'color' => '#ffff11',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Message',
            'message' => 'Test emoticon 😀😀😀',
            'color' => '#ffff11',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testEmpty(): void
    {
        $response = static::createClient()->request('POST', '/api/messages', ['json' => []]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Message',
            'message' => null,
            'color' => null,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testNotFound(): void
    {
        $response = static::createClient()->request('GET', '/api/messages/42', ['json' => []]);

        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            "@context" => "/api/contexts/Error",
            "@type" => "hydra:Error",
            "hydra:title" => "An error occurred",
            "hydra:description" => "Not Found",
        ]);
    }

    public function testShouldNotReturnKeys(): void
    {
        $client = static::createClient()->request('POST', '/api/messages', ['json' => [
            'message' => 'Test Space in End ',
            'color' => '#ffff11',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $response = $client->getContent();

        $message = json_decode($response, true);

        $this->assertArrayHasKey("@context", $message);
        $this->assertArrayHasKey("@id", $message);
        $this->assertArrayHasKey("@type", $message);
        $this->assertArrayHasKey("message", $message);
        $this->assertArrayHasKey("color", $message);
        $this->assertArrayHasKey("uuid", $message);
        $this->assertArrayHasKey("createdAt", $message);

        $this->assertArrayNotHasKey("id", $message);
    }
}
