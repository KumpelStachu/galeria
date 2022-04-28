<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['profile', 'profile:read']],
    denormalizationContext: ['groups' => ['profile', 'profile:write']],
    collectionOperations: ['get'],
    itemOperations: [
        'get',
        'patch' => ['security' => 'is_granted("ROLE_ADMIN") or object == user"'],
        'delete' => ['security' => 'is_granted("ROLE_ADMIN")'],
    ]
)
]
#[ORM\Entity(repositoryClass: ProfileRepository::class), ORM\HasLifecycleCallbacks]
class Profile implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    #[Groups(['profile:read'])]
    private int $id;

    #[Groups(['profile:read'])]
    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;
    
    #[Groups(['profile'])]
    #[ORM\Column(length: 30, unique: true)]
    private string $username;

    #[Groups(['profile:read'])]
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    #[Groups(['profile'])]
    #[ORM\Column(length: 320)]
    private string $description = '';

    #[Groups(['profile'])]
    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: Gallery::class, orphanRemoval: true)]
    private Collection $galleries;

    #[ApiSubresource]
    #[Groups(['profile'])]
    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->galleries = new ArrayCollection();
        $this->comments = new ArrayCollection();
        // $this->tags = new ArrayCollection();
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

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $gallery->setProfile($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): self
    {
        if ($this->galleries->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getProfile() === $this) {
                $gallery->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProfile($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProfile() === $this) {
                $comment->setProfile(null);
            }
        }

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
