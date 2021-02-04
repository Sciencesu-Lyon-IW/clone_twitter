<?php

namespace App\Entity;
use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
// there are generators for UUID V1 and V6 too
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Json;


/**
 * Posts
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass=PostsRepository::class)

 */
class Posts
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="body", type="string", length=245, nullable=true)
     */
    private $body;

    /**
     * @var string|null
     *
     * @ORM\Column(name="picture_path", type="string", length=245, nullable=true)
     */
    private $picturePath;

    /**
     * @var int|null
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var string|null
     *
     * @ORM\Column(name="extension", type="string", length=45, nullable=true)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="createAt", type="string", nullable=true)
     */
    private $createat;

    /**
     * @var string
     *
     * @ORM\Column(name="updateAt", type="string", nullable=true)
     */
    private $updateat;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="posts", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="posts", cascade={"persist"})
     */
    private $user_id;

    /**
     * Constructor
     */
    public function __construct()
    {

        $this->user = new ArrayCollection();
        $this->user_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(?string $picturePath): self
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getCreateat(): string
    {
        return $this->createat;
    }

    public function setCreateat(?string $createat ): self
    {
        $this->createat = $createat;

        return $this;
    }

    public function getUpdateat(): string
    {
        return $this->updateat;
    }

    public function setUpdateat(?string $updateat): self
    {
        $this->updateat =$updateat;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->addPost($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            $user->removePost($this);
        }

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(user $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
        }

        return $this;
    }

    public function removeUserId(user $userId): self
    {
        $this->user_id->removeElement($userId);

        return $this;
    }
    public function __toString(): string
    {
        return $this->getId();
    }
}
