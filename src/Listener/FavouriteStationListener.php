<?php

namespace App\Listener;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use App\Entity\piRadio\FavouriteStation;
use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FavouriteStationListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(FavouriteStation $station, LifecycleEventArgs $event): void
    {
        $dateTimeNow = new DateTime('now');
        $station->setCreatedAt($dateTimeNow);


        if ($station->getUser() === null) {
            /** @var User $current_user */
            $current_user = $this->security->getUser();
            $station->setUser($current_user);
        }
    }
}
