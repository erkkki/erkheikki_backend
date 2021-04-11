<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Message;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $message = new Message();
        $message->setMessage('lorem ipsum');
        $manager->persist($message);

        $manager->flush();
    }
}
