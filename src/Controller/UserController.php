<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\DecodeTokenJwt;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\ExpiredException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $request;
    private $userRepository;
    private $entityManager;
    private $decodeJwt;

    public function __construct(
        RequestStack $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        DecodeTokenJwt $decodeJwt
    )
    {
        $this->request = $request;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->decodeJwt = $decodeJwt;
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
        $user = $this->userRepository->find($idToAuthorize);

        //Set les données si l'utilisateur est autorisé
        switch ($authorize){
            case true:
                $user->setIsAuthorize($authorize);
                $user->setRole($role);
                $message = "Accès autorisé";
                break;
            case false:
                $user->setIsAuthorize($authorize);
                $user->setRole($role);
                $message = "Accès refusé";
                break;
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $this->json(["message" => $message, "code" => 200, true]);
    }

    /**
     * Cette fonction liste les utilisateurs venant de s'enregistrer
     * @Route ("/admin/get/user", name="getUserRequest", methods={"GET"})
     * @return JsonResponse
     */
    public function getNewUserRequest(): JsonResponse
    {
        $allNewUser = $this->userRepository->findBy(['isAuthorize' => false]);
        return $this->json(["allNewUser" => $allNewUser, "code" => 200, true]);
    }

    /**
     * Récupère le role de l'utilisateur;
     * Appelle une fonction qui détruit le token JWT
     * @Route("/admin/role/user", name="get_role", methods={"POST"})
     * @return JsonResponse
     */
    public function getRolesOfCurrentUser()
    {
        try {
            // Get Token from front
            $tokenJson = $this->request->getCurrentRequest()->getContent();
            $token = json_decode($tokenJson, true);
            $destructJwt = $this->decodeJwt->decodeJwt($token);
            $user = $this->userRepository->findOneBy(['email' => $destructJwt['email']]);

            if (empty($user)) {
                return new JsonResponse(
                    [
                        'role' => null,
                        'message' => 'L\'utilisateur n\'est pas connecté ou n\'a pas de role..',
                        'errorGetToken' => false
                    ], 200, [], false
                );
            }
            $role = $user->getRole();
            return new JsonResponse(
                [
                    'role' => $role,
                    'email' => $destructJwt['email'],
                    'errorGetToken' => false
                ], 200, [], false
            );
        } catch (ExpiredException $exception) {
            if($exception->getMessage() == "Expired token"){
                return new JsonResponse(
                    [
                        'role' => null,
                        'errorGetToken' => true,
                        'message' => 'Redirection a la page de connexion'
                    ], 200, [], false
                );
            }
        }
    }
}
