<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Return current logged in user | null if not
     * @Route("/api/user", name="user")
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $serializedEntity = $this->container->get('serializer')->serialize($user, 'json');

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($serializedEntity);

        return $response;
    }
}
