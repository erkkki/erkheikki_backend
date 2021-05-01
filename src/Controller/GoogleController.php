<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     * @param ClientRegistry $clientRegistry
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/connect/google", name="connect_google_start")
     *
     */
    public function connectAction(
        ClientRegistry $clientRegistry,
        Request $request,
        SessionInterface $session
    ): RedirectResponse {
        $referer = $session->get('referer');
        
        if ($referer === null) {
            $referer = $request->headers->get('referer');

            $session->set('referer', $referer);
        }


        return $clientRegistry
            ->getClient('google')
            ->redirect([
                'profile', 'email' // the scopes you want to access
            ], []);
    }

    /**
     * After going to Google, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(SessionInterface $session): RedirectResponse
    {
        $referer = $session->get('referer');

        $session->remove('referer');

        if ($referer !== null) {
            return $this->redirect($referer);
        }
        return $this->redirectToRoute('main');
    }
}
