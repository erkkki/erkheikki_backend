<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET"})
     */
    public function login(Request $request, SessionInterface $session): Response
    {
        $referer = $request->headers->get('referer');

        $session->set('referer', $referer);

        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     *
     * @throws \Exception
     */
    public function logout(): void
    {
        throw new \Exception('this should not be reached!');
    }
}
