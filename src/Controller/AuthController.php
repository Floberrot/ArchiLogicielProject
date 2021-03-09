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
     * @return Response
     * @Route ("/login", name="login")
     */
    public function loginUser(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $dataLogin = $request->getContent();
        $dataLogin = json_decode($dataLogin, true);
        $email = $dataLogin['email'];
        $user = $userRepository->findOneBy(['email' => $email]);
        if (!$user || !$passwordEncoder->isPasswordValid($user, $dataLogin['mdp'])) {
            return $this->json([
                'message' => 'email or password is wrong.',
            ]);
        }
        $key = "example_key";
        $payload = [
            "email" => $email,
            "exp" => (new \DateTime())->modify("+5 minutes")->getTimestamp(),
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $this->json([
            'message' => 'success login',
            'token' => sprintf('Bearer %s', $jwt)
        ]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @Route ("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): JsonResponse
    {
        $askRegister = $request->getContent();
        $askRegister = json_decode($askRegister, true);
        $email = $askRegister['email'];
        $plainPassword = $askRegister['mdp'];
        $user = new User();
        $user
            ->setEmail($email)
            ->setPassword($passwordEncoder->encodePassword($user, $plainPassword))
            ->setIsAuthorize(true);
        $em->persist($user);
        $em->flush();
        return $this->json([
            'message' => 'you account has been created'
        ]);
    }
}
