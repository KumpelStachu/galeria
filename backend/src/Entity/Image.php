<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\PostImageController;
use App\Controller\GetImageController;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get',
        'delete' => ['security_post_denormalize' => 'is_granted("ROLE_ADMIN") or (object.getProfile() == user)'],
        'file' => [
            'method' => 'GET',
            'path' => '/images/{id}/file',
            'controller' => GetImageController::class,
            'openapi_context' => [
                'responses' => [
                    '200' => [
                        'content' => [
                            'image/*' => [
                                'schema' => [
                                    'type' => 'string',
                                    'format' => 'binary',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
)]
#[ApiFilter(OrderFilter::class)]
#[ORM\Entity(repositoryClass: ImageRepository::class), ORM\HasLifecycleCallbacks]
class Image
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $id;

    #[ApiFilter(DateFilter::class)]
    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\ManyToOne(targetEntity: Profile::class)] //, inversedBy: 'images'
    #[ORM\JoinColumn(nullable: false)]
    private Profile $profile;

    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\ManyToOne(targetEntity: Gallery::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private Gallery $gallery;

    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getFile(): string
    {
        return '/api/images/'.$this->id.'/file';
    }
}
