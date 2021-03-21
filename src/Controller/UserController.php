<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class UserController extends AbstractController
{
    private $request;
    private $userRepository;
    private $entityManager;

    public function __construct(
        RequestStack $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    )
    {
        $this->request = $request;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * Cette fonction permet d'autoriser ou non l'accès à un nouvel utilisateur et de lui assigner un role.
     * @Route("/admin/authorize/{idToAuthorize}", name="autorizeUser", methods={"POST"})
     * @param $idToAuthorize
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function authorizeUser($idToAuthorize): JsonResponse
    {
        //Récupération des données d'autorisation et de rôle envoyé par le manager
        $dataReceive = json_decode($this->request->getCurrentRequest()->getContent(), true);
        $authorize = $dataReceive['isAuthorize'];
        $role = $dataReceive['role'];
        $message = "";

        //Set les données si l'utilisateur est autorisé
        switch ($authorize){
            case true:
                $user = $this->userRepository->find($idToAuthorize);
                $user->setIsAuthorize($authorize);
                $user->setRole($role);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $message = "Accès autorisé";
                break;
            case false:
                $message = "Accès refusé";
                break;
        }
        return new JsonResponse(
            [
                "message" => $message,
            ], 200, [], true
        );
    }

    /**
     * Cette fonction liste les utilisateurs venant de s'enregistrer
     * @Route ("/admin/getUserRequest", name="getUserRequest", methods={"GET"})
     * @return JsonResponse
     */
    public function getNewUserRequest(): JsonResponse
    {
        $allNewUser = $this->userRepository->findBy(['isAuthorize' => false]);
//        return new JsonResponse(
//            [
//                "allNewUser" => $allNewUser
//            ], 200, [], true
//        );
        return $this->json(["allNewUser" => $allNewUser, "code" => 200, true]);
    }

}
