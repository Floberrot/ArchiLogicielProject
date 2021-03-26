<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return JsonResponse
     * @Route ("/login", name="login")
     */
    public function login(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {
        $dataLogin = $request->getContent();
        $dataLogin = json_decode($dataLogin, true);
        $email = $dataLogin['email'];
        $user = $userRepository->findOneBy(['email' => $email]);
        $role = $user->getRole();
        if (!$user || !$passwordEncoder->isPasswordValid($user, $dataLogin['mdp'])) {
            return $this->json([
                'isValid' => false,
                'message' => 'Email or password is wrong.',
            ]);
        }
        if ($user->getIsAuthorize() === false) {
            return $this->json([
                'isValid' => true,
                'isAuthorized' => false,
                'message' => 'Votre demande est en attente.',
            ]);
        }
        // create token
        $key = "secret_key";
        $payload = [
            "email" => $email,
            "role" => $role,
            "exp" => (new \DateTime())->modify("+1 day")->getTimestamp(),
        ];
        $jwt = JWT::encode($payload, $key);
        return $this->json([
            'isValid' => true,
            'isAuthorized' => true,
            'message' => 'success login',
            'token' => sprintf('Bearer %s', $jwt),
            'role' => $role
        ]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @Route ("/register", name="register")
     */
    public function register(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): JsonResponse
    {
        $askRegister = $request->getContent();
        $askRegister = json_decode($askRegister, true);
        $email = $askRegister['email'];
        $plainPassword = $askRegister['mdp'];
        $user = $userRepository->findOneBy(['email' => $email]);
        if ($user) {
            return $this->json([
                'RegistrationOK' => false,
            ]);
        } else {
            $user = new User();
            $user
                ->setEmail($email)
                ->setPassword($passwordEncoder->encodePassword($user, $plainPassword))
                ->setIsAuthorize(false);
            $em->persist($user);
            $em->flush();
            return $this->json([
                'RegistrationOK' => true,
            ]);
        }
    }
}
