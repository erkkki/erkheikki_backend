<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutSubscriber implements EventSubscriberInterface
{
    /**
     * After logout redirect back to original page
     * @param \Symfony\Component\Security\Http\Event\LogoutEvent $event
     */
    public function onLogoutEvent(LogoutEvent $event): void
    {
        $request = $event->getRequest();
        $referer = $request->headers->get('referer');

        if ($referer !== null) {
            $event->setResponse(
                new RedirectResponse($referer)
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
