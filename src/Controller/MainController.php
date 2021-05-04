<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): RedirectResponse
    {
        $env = $this->getParameter('app.env');

        if ($env === "prod") {
            return $this->redirect("https://www.erkheikki.fi");
        }
        return $this->redirectToRoute('app_login');
    }
}
