<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class MessageTest extends ApiTestCase
{
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
}
