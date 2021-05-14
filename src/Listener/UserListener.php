<?php

namespace App\Listener;

use App\Entity\User;
use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserListener
{
    public function prePersist(User $user, LifecycleEventArgs $event): void
    {
        $dateTimeNow = new DateTime('now');
        $user->setCreatedAt($dateTimeNow);
        $user->setLastSeen($dateTimeNow);
    }
}
