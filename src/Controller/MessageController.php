<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/api/message", name="api message ")
 */
class MessageController extends AbstractFOSRestController
{
    /**
     * @Rest\Get()
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(['messages' => '3']);
    }

    /**
     * New Message
     * @Rest\Post()
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        return new JsonResponse(['messages' => '2']);
    }

    /**
     * Get message by uuid
     * @Rest\Get("/{uuid}")
     * @param string $uuid
     * @return JsonResponse
     */
    public function message(string $uuid): JsonResponse
    {
        return new JsonResponse(['messages' => '1']);
    }
}
