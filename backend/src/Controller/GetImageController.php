<?php

namespace App\Controller;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;

#[AsController]
class GetImageController extends AbstractController
{
    #[Route('/api/images/{id}/file', name: 'get_image_file')]
    public function __invoke(string $imagesPath, Image $image): Response
    {
        return $this->file($imagesPath.'/'.$image->getId());
    }
}
