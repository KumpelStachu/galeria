<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security_post_denormalize' => 'is_granted("ROLE_ADMIN") or (object.getProfile() == user)'],
    ],
    itemOperations: [
        'get',
        'delete' => ['security_post_denormalize' => 'is_granted("ROLE_ADMIN") or (object.getProfile() == user)'],
    ]
)]
#[ApiFilter(OrderFilter::class)]
#[ORM\Entity(repositoryClass: CommentRepository::class), ORM\HasLifecycleCallbacks]
class Comment
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $id;

    #[ApiFilter(DateFilter::class)]
    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[ORM\Column(length: 320)]
    private string $content;

    #[ApiSubresource(maxDepth: 1)]
    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Profile $profile;

    #[ApiSubresource(maxDepth: 1)]
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
