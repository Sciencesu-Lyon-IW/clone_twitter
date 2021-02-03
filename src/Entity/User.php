<?php

namespace App\Entity;

use App\Repository\UserRepository;
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
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}), @ORM\UniqueConstraint(name="firstname_UNIQUE", columns={"firstname"})}, indexes={@ORM\Index(name="fk_user_profile_cover_user1_idx", columns={"profile_cover_user_id"}), @ORM\Index(name="fk_user_profile_picture_user_idx", columns={"profile_picture_user_id"})})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var json|null
     *
     * @ORM\Column(name="roles", type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=45)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=45)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=45)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bio", type="string", length=245, nullable=true)
     */
    private $bio;

    /**
     *
     * @ORM\Column(name="location", type="string", length=45, nullable=true)
     */
    private $location;

    /**
     *
     * @ORM\Column(name="creatAt", type="datetime", nullable=true)
     */
    private $creatat;

    /**
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ProfileCoverUser", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_cover_user_id", referencedColumnName="id")
     * })
     */
    private $profileCoverUser;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ProfilePictureUser", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_picture_user_id", referencedColumnName="id")
     * })
     */
    private $profilePictureUser;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="MediaUser", mappedBy="user")
     */
    private $mediaUser;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Followers", inversedBy="user", cascade={"persist"})
     * @ORM\JoinTable(name="user_has_followers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="followers_id", referencedColumnName="id")
     *   }
     * )
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity=Posts::class, mappedBy="user_id")
     */
    private $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaUser = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }



    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

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

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getProfileCoverUser(): ?ProfileCoverUser
    {
        return $this->profileCoverUser;
    }

    public function setProfileCoverUser(?ProfileCoverUser $profileCoverUser): self
    {
        $this->profileCoverUser = $profileCoverUser;

        return $this;
    }

    public function getProfilePictureUser(): ?ProfilePictureUser
    {
        return $this->profilePictureUser;
    }

    public function setProfilePictureUser(?ProfilePictureUser $profilePictureUser): self
    {
        $this->profilePictureUser = $profilePictureUser;

        return $this;
    }

    /**
     * @return Collection|MediaUser[]
     */
    public function getMediaUser(): Collection
    {
        return $this->mediaUser;
    }

    public function addMediaUser(MediaUser $mediaUser): self
    {
        if (!$this->mediaUser->contains($mediaUser)) {
            $this->mediaUser[] = $mediaUser;
            $mediaUser->addUser($this);
        }

        return $this;
    }

    public function removeMediaUser(MediaUser $mediaUser): self
    {
        if ($this->mediaUser->removeElement($mediaUser)) {
            $mediaUser->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Followers[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(Followers $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
        }

        return $this;
    }

    public function removeFollower(Followers $follower): self
    {
        $this->followers->removeElement($follower);

        return $this;
    }

    /**
     * @return Collection|Posts[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addUserId($this);
        }

        return $this;
    }

    public function removePost(Posts $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeUserId($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->username;
    }
}
