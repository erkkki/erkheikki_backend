<?php

namespace App\DataFixtures;

use App\Entity\piRadio\FavouriteStation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FavouriteStationFixtures extends Fixture implements DependentFixtureInterface
{
    private array $stationsData = [
        ['name' => 'HitMix', 'stationuuid' => 'de4e5670-8dcb-11e9-a6c6-52543be04c81'],
        ['name' => 'MANGORADIO', 'stationuuid' => '78012206-1aa1-11e9-a80b-52543be04c81'],
        ['name' => 'Radio SuomiRock', 'stationuuid' => 'af0a88c3-8936-11e8-aa66-52543be04c81'],
        ['name' => 'Radio Rock', 'stationuuid' => '11945fcb-d365-11e8-a54a-52543be04c81'],
    ];

    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixtures::TEST_USER);

        foreach ($this->stationsData as &$station) {
            $newFavStation = new FavouriteStation();
            $newFavStation->setUser($user);
            $newFavStation->setName($station['name']);
            $newFavStation->setStationuuid($station['stationuuid']);
            $manager->persist($newFavStation);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
