<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\ImageUploadController;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            // 'security' => 'object.profile == user and object.gallery.profile == user',
            'controller' => ImageUploadController::class,
            'deserialize' => false,
            'openapi_context' => [
                'request_body' => [
                    'required' => true,
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properites' => [
                                    'gallery' => [
                                        'type' => 'int',
                                        'example' => 1,
                                    ],
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    itemOperations: [
        'get',
        'delete' => ['security' => 'is_granted("ROLE_ADMIN") or object.profile == user'],
    ]
)]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    #[ApiProperty(
        iri: 'http://schema.org/image',
        attributes: [
            'openapi_context' => [
                'type' => 'string'
            ]
        ]
    )]
    private string $src;

    #[ORM\ManyToOne(targetEntity: Profile::class)] //, inversedBy: 'images'
    #[ORM\JoinColumn(nullable: false)]
    private Profile $profile;

    #[ORM\ManyToOne(targetEntity: Gallery::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private Gallery $gallery;

    #[ORM\PrePersist]
    public function updatedTimestamps()
    {
        if ($this->createdAt == null) {
            $this->createdAt = new \DateTimeImmutable('now');
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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
}
