<?php

namespace App\Entity;

use App\Repository\FollowsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FollowsRepository::class)
 */
class Follows
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $following;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $followers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_follow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowing(): ?string
    {
        return $this->following;
    }

    public function setFollowing(string $following): self
    {
        $this->following = $following;

        return $this;
    }

    public function getFollowers(): ?string
    {
        return $this->followers;
    }

    public function setFollowers(string $followers): self
    {
        $this->followers = $followers;

        return $this;
    }

    public function getCreateAt(): ?string
    {
        return $this->createAt;
    }

    public function setCreateAt(string $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?string
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?string $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getHasFollow(): ?bool
    {
        return $this->has_follow;
    }

    public function setHasFollow(bool $has_follow): self
    {
        $this->has_follow = $has_follow;

        return $this;
    }
}
