<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Message;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $message = new Message();
        $message->setMessage('Lorem ipsum');
        $manager->persist($message);

        $message = new Message();
        $message->setMessage('Lorem ipsum two');
        $manager->persist($message);

        $message = new Message();
        $message->setMessage('Lorem ipsum three');
        $manager->persist($message);

        $manager->flush();
    }
}
