<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\FileUploader;
use App\Entity\Image;

#[AsController]
class ImageUploadController extends AbstractController
{
    public function __invoke(Request $request, FileUploader $fileUploader): Image
    {
        $uploadedFile = $request->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
 
        $image = new Image();
        $image->gallery = $request->get('gallery');
 
        $image->src = $fileUploader->upload($uploadedFile);
 
        return $image;
    }
}
