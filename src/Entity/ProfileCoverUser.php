<?php

namespace App\Entity;

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
 * ProfileCoverUser
 *
 * @ORM\Table(name="profile_cover_user")
 * @ORM\Entity(repositoryClass=ProfileCoverUserRepository::class)

 */
class ProfileCoverUser
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
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="creatAt", type="datetime", nullable=true)
     */
    private $creatat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updateAt", type="datetime", nullable=true)
     */
    private $updateat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getCreatat(): ?\DateTimeInterface
    {
        return $this->creatat;
    }

    public function setCreatat(?\DateTimeInterface $creatat): self
    {
        $this->creatat = $creatat;

        return $this;
    }

    public function getUpdateat(): ?\DateTimeInterface
    {
        return $this->updateat;
    }

    public function setUpdateat(?\DateTimeInterface $updateat): self
    {
        $this->updateat = $updateat;

        return $this;
    }


}
