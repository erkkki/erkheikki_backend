<?php

namespace App\Controller\Api;

use App\Entity\piRadio\FavouriteStation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class FavouriteController extends AbstractController
{
    /**
     * @Route("/api/favourite_stations", name="favourite_stations_add",  methods="POST")
     */
    public function add(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'])) {
            return $this->json([], $status = 422);
        }
        if (!isset($data['stationuuid'])) {
            return $this->json([], $status = 422);
        }

        $newFav = new FavouriteStation();
        $newFav->setUser($user);
        $newFav->setName($data['name']);
        $newFav->setStationuuid($data['stationuuid']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newFav);
        $em->flush();

        return $this->json([], $status = 201);
    }
}
