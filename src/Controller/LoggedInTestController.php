<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoggedInTestController extends AbstractController
{
    /**
     * @Route("/loggedin", name="logged_in_test")
     */
    public function index(): Response
    {
        return $this->render('logged_in_test/index.html.twig', [
            'controller_name' => 'LoggedInTestController',
        ]);
    }
}
