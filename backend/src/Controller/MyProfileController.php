<?php

namespace App\Controller;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Profile;

#[AsController]
class MyProfileController extends AbstractController
{
    #[Route('/profiles/me', name: 'my_profile')]
    public function __invoke(): ?Profile
    {
        return $this->getUser();
    }
}
