<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Repository\ImageRepository;
use App\Entity\Gallery;
use App\Entity\Profile;
use App\Entity\Image;

#[AsController]
class AddImageController extends AbstractController
{
    public function __invoke(string $imagesPath, Request $request, Gallery $gallery, ImageRepository $imageRepository): Image
    {
        $base64file = $request->get('file');
        if (!$base64file) {
            throw new BadRequestHttpException('"file" is required');
        }
 
        $image = new Image();
        $image->setGallery($gallery);
        $image->setProfile($this->getUser());
        $imageRepository->add($image);
        
        $content = explode(';base64,', $base64file)[1];
        $data = base64_decode($content);
        file_put_contents($imagesPath . '/' . $image->getId(), $data);
  
        return $image;
    }
}
