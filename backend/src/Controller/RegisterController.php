<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProfileRepository;
use App\Entity\Profile;

class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'api_register')]
    public function index(ProfileRepository $profileRepository, Request $request, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTManager): Response
    {
        $username = $request->get('username');
        if ($username == null) {
            throw new BadRequestHttpException('username is required');
        }
        
        $plaintextPassword = $request->get('password');
        if ($plaintextPassword == null) {
            throw new BadRequestHttpException('password is required');
        }

        $profile = $profileRepository->findOneBy(['username' => $username]);
        if ($profile != null) {
            throw new ConflictHttpException('user already exists');
        }

        $user = new Profile();
        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setUsername($username);
        $user->setPassword($hashedPassword);
        $profileRepository->add($user);

        return $this->json([
            'token' => $JWTManager->create($user),
        ]);
    }
}
