<?php

namespace App\Tests\Api;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageTestTest extends WebTestCase
{
    public function testMessageAddNew(): void
    {
        $client = static::createClient();
        $data = [
            'message' => 'Post test message',
            'color' => '#ffff11',
        ];
        $this->jsonRequest($client, 'POST', '/api/messages', $data);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals('Post test message', $responseArray['message']);
        $this->assertEquals('#ffff11', $responseArray['color']);
    }

    public function testMessageSpaceInEnd(): void
    {
        $client = static::createClient();
        $data = [
            'message' => 'Test Space in End ',
            'color' => '#ffff11',
        ];
        $this->jsonRequest($client, 'POST', '/api/messages', $data);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals('Test Space in End ', $responseArray['message']);
        $this->assertEquals('#ffff11', $responseArray['color']);
    }
    public function testMessageEmoticon(): void
    {
        $client = static::createClient();
        $data = [
            'message' => 'Test emoticon 😀😀😀',
            'color' => '#ffff11',
        ];
        $this->jsonRequest($client, 'POST', '/api/messages', $data);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals('Test emoticon 😀😀😀', $responseArray['message']);
        $this->assertEquals('#ffff11', $responseArray['color']);
    }
    public function testMessagePostEmpty(): void
    {
        $client = static::createClient();
        $this->jsonRequest($client, 'POST', '/api/messages', []);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals('', $responseArray['message']);
        $this->assertEquals('', $responseArray['color']);
    }

    public function testMessageGetById(): void
    {
        $client = static::createClient();

        /** @var MessageRepository $messageRepo */
        $messageRepo = static::$container->get(MessageRepository::class);
        $message = $messageRepo->findOneBy(['message' => 'Post test message']);

        $client->request('GET', '/api/messages/' . $message->getId());

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals('Post test message', $responseArray['message']);
        $this->assertEquals('#ffff11', $responseArray['color']);
    }

    public function testMessageNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/messages/43');

        $this->assertResponseHeaderSame('Content-Type', 'application/ld+json; charset=utf-8');

        /** @var string $response */
        $response = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals('An error occurred', $responseArray['hydra:title']);
        $this->assertEquals('Invalid identifier value or configuration.', $responseArray['hydra:description']);
    }

    private function jsonRequest(KernelBrowser $client, string $method, string $url, array $content = null): void
    {
        $content = json_encode($content);

        if (!$content) {
            $content = null;
        }

        $client->request(
            $method,
            $url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );
    }
}
