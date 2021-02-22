<?php

namespace App\Entity;

use App\Repository\RepostRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
// there are generators for UUID V1 and V6 too
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Json;
/**
 * Repost
 *
 * @ORM\Table(name="repost", indexes={@ORM\Index(name="fk_repost_posts1_idx", columns={"posts_id"}), @ORM\Index(name="fk_repost_user1_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass=RepostRepository::class)
 */
class Repost
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
     * @var string
     *
     * @ORM\Column(name="createAt", type="string", nullable=true)
     */
    private $createat;

    /**
     * @var \Posts
     *
     * @ORM\ManyToOne(targetEntity="Posts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="posts_id", referencedColumnName="id")
     * })
     */
    private $posts;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasReposted;

    public function __construct()
    {
        $this->createat = date("Y-m-d H:i:s");

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateat(): ?string
    {
        return $this->createat;
    }

    public function setCreateat(?string $createat): self
    {
        $this->createat = $createat;

        return $this;
    }

    public function getPosts(): ?Posts
    {
        return $this->posts;
    }

    public function setPosts(?Posts $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getHasReposted(): ?bool
    {
        return $this->hasReposted;
    }

    public function setHasReposted(bool $hasReposted): self
    {
        $this->hasReposted = $hasReposted;

        return $this;
    }


}
