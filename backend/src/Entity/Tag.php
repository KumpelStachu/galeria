<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security_post_denormalize' => 'is_granted("ROLE_ADMIN") or (is_granted("ROLE_CREATOR") and (object.getProfile() == user))'],
    ],
    itemOperations: [
        'get',
        'delete' => ['security_post_denormalize' => 'is_granted("ROLE_ADMIN") or (object.getProfile() == user)'],
    ]
)]
#[ApiFilter(OrderFilter::class)]
#[ORM\Entity(repositoryClass: TagRepository::class), ORM\HasLifecycleCallbacks]
class Tag
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $id;

    #[ApiFilter(DateFilter::class)]
    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[ORM\Column(length: 100)]
    private string $name;

    #[ApiSubresource(maxDepth: 1)]
    #[ORM\ManyToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Profile $profile;

    #[ApiSubresource(maxDepth: 1)]
    #[ORM\ManyToMany(targetEntity: Gallery::class, mappedBy: 'tags')]
    private Collection $galleries;

    public function __construct()
    {
        $this->galleries = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Gallery>
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): self
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries[] = $gallery;
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): self
    {
        $this->galleries->removeElement($gallery);

        return $this;
    }
}
