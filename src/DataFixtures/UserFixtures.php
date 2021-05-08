<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{

    public const TEST_USER = 'test-user';
    public const SECOND_TEST_USER = 'second-test-user';

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("test@gmail.com");
        $user->setGoogleId("testing");
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail("second_test@gmail.com");
        $user2->setGoogleId("second_test");
        $manager->persist($user2);

        $manager->flush();


        $this->addReference(self::TEST_USER, $user);
        $this->addReference(self::SECOND_TEST_USER, $user2);
    }
}
