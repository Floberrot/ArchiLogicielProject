<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class UserController extends AbstractController
{
    /**
     * @Route("/get/role/user", name="get_role", methods={"GET"})
     * @return JsonResponse
     */
    public function getRolesOfCurrentUser()
    {
        $user = $this->getUser();
        if (empty($user)) {
            return new JsonResponse(
                [
                    'role' => null,
                    'message' => 'L\'utilisateur n\'est pas connecté ou n\'a pas de role..'
                ], 200, [], true
            );
        }
        $role = $user->getRole();
        return new JsonResponse(
            [
                'role' => $role
            ], 200, [], true
        );
    }
}
