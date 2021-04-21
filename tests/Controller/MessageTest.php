<?php

namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class MessageTest extends ApiTestCase
{
    public function testFixtureCount(): void
    {
        $response = static::createClient()->request('GET', '/api/message');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $this->assertJsonContains([
            'messages' => '3',
        ]);
    }

    public function testGetMessageByUuid(): void
    {
        $response = static::createClient()->request('GET', '/api/message/1');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateNewMessage(): void
    {
        $response = static::createClient()->request('POST', '/api/message', ['json' => [
            'message' => 'Test message',
            'color' => '#121212',
        ]]);
        $this->assertResponseIsSuccessful();
    }
}
