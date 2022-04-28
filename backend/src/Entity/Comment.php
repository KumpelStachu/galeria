<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security' => 'object.profile == user'],
    ],
    itemOperations: [
        'get',
        'delete' => ['security' => 'is_granted("ROLE_ADMIN") or object.profile == user'],
    ]
)]
#[ORM\Entity(repositoryClass: CommentRepository::class), ORM\HasLifecycleCallbacks]
class Comment
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(length: 320)]
    private string $content;

    // #[ApiSubresource]
    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Profile $profile;

    // #[ApiSubresource]
    #[ORM\ManyToOne(targetEntity: Gallery::class, inversedBy: 'comments')]
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
