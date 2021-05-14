<?php

namespace App\Listener;

use App\Entity\Message;
use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MessageListener
{
    public function prePersist(Message $message, LifecycleEventArgs $event): void
    {
        $dateTimeNow = new DateTime('now');
        $message->setCreatedAt($dateTimeNow);
    }
}
