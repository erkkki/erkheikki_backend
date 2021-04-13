<?php

namespace App\Tests\DataFixtures;

use App\Repository\MessageRepository;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageTest extends KernelTestCase
{
    /**
     * @var \Doctrine\Persistence\ObjectManager
     */
    private $entityManager;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testMessage(): void
    {

        var_dump($this->entityManager);
        $messageRepo = $this->entityManager->getRepository(Message::class);
        $message = $messageRepo->find(1);

        $this->assertEquals('Lorem ipsum', $message->getMessage());
    }
}
