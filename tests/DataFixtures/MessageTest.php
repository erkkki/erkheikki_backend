<?php

namespace App\Tests\DataFixtures;

use App\Repository\MessageRepository;
use App\Entity\Message;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageTest extends KernelTestCase
{
    /**
     * @var ObjectManager
     */
    private $ObjectManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->ObjectManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testMessageFixtures(): void
    {
        $messageRepo = $this->ObjectManager->getRepository(Message::class);

        $message = $messageRepo->find(1);

        $this->assertEquals('Lorem ipsum', $message->getMessage());
        $this->assertEquals('#ff12ff', $message->getColor());

        $message = $messageRepo->find(2);


        $this->assertEquals('Lorem ipsum two ', $message->getMessage());
        $this->assertEquals('#ff12ff', $message->getColor());

        $message = $messageRepo->find(3);
        /** Should be empty / null */
        $this->assertEquals(null, $message->getMessage());
        $this->assertEquals(null, $message->getColor());
    }

    public function editMessageTest(): void
    {
        $messageRepo = $this->ObjectManager->getRepository(Message::class);

        $message = $messageRepo->find(1);

        $this->assertEquals('Lorem ipsum', $message->getMessage());

        $this->updateMessage($message);

        $message = $messageRepo->find(1);

        $this->assertEquals('Lorem ipsum updated', $message->getMessage());
    }

    public function uuidTest(): void
    {
        $messageRepo = $this->ObjectManager->getRepository(Message::class);

        $message = $messageRepo->find(1);
        $message_two = $messageRepo->find(2);

        $this->assertNotEquals($message->getUuid(), $message_two->getUuid());
    }

    private function updateMessage(Message $message): void
    {
        $message->setMessage('Lorem ipsum updated');

        $this->ObjectManager->persist($message);

        $this->ObjectManager->flush();
    }
}
