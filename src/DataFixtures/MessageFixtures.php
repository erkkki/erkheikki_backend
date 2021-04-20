<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Message;
use App\Service\UuidGenerator;

class MessageFixtures extends Fixture
{

    private UuidGenerator $generator;

    public function __construct(UuidGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function load(ObjectManager $manager): void
    {
        $message = new Message();
        $message->setMessage('Lorem ipsum');
        $message->setColor('#ff12ff');
        $message->setUuid($this->generator->getUuidShort());
        $manager->persist($message);

        $message = new Message();
        $message->setMessage('Lorem ipsum two');
        $message->setColor('#ff12ff');
        $message->setUuid($this->generator->getUuidShort());
        $manager->persist($message);

        $message = new Message();
        $message->setMessage();
        $message->setColor();
        $message->setUuid($this->generator->getUuidShort());
        $manager->persist($message);

        $manager->flush();
    }
}
