<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\AddImageController;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security_post_deserialize' => 'is_granted("ROLE_ADMIN") or (is_granted("ROLE_CREATOR") and (object.getProfile() == user))'],
        'addimage' => [
            'method' => 'POST',
            'path' => '/galleries/{id}/images',
            'security_post_deserialize' => 'is_granted("ROLE_ADMIN") or (is_granted("ROLE_CREATOR") and (object.getProfile() == user))',
            'controller' => AddImageController::class,
            'deserialize' => false,
            'openapi_context' => [
                'parameters' => [
                    'path' => [
                        'in' => 'path',
                        'name' => 'id',
                        'required' => true,
                        'description' => 'Resource identifier',
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                ],
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properites' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'base64',
                                    ],
                                ],
                            ],
                            'example' => [
                                'file' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAMSURBVBhXY/j//z8ABf4C/qc1gYQAAAAASUVORK5CYII=',
                            ],
                        ],
                    ],
                ],
                'responses' => [
                    '201' => [
                        'description' => 'Image resource created',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Image',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ],
    itemOperations: [
        'get',
        'patch' => ['security' => 'is_granted("ROLE_ADMIN") or object.profile == user"'],
        'delete' => ['security' => 'is_granted("ROLE_ADMIN") or object.profile == user'],
    ],
)]
#[ORM\Entity(repositoryClass: GalleryRepository::class), ORM\HasLifecycleCallbacks]
class Gallery
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(length: 320)]
    private string $title;

    #[ORM\Column]
    private bool $nsfw = false;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'galleries')]
    #[ORM\JoinColumn(nullable: false)]
    private Profile $profile;

    #[ApiSubresource]
    #[ORM\OneToMany(mappedBy: 'gallery', targetEntity: Image::class, orphanRemoval: true)]
    private Collection $images;

    #[ApiSubresource]
    #[ORM\OneToMany(mappedBy: 'gallery', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ApiSubresource]
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setGallery($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getGallery() === $this) {
                $image->setGallery(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

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
            $comment->setGallery($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getGallery() === $this) {
                $comment->setGallery(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getNsfw(): ?bool
    {
        return $this->nsfw;
    }

    public function setNsfw(bool $nsfw): self
    {
        $this->nsfw = $nsfw;

        return $this;
    }
}
