<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function eraseCredentials(): void
    {
        // Implement the eraseCredentials method here
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('user')]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups('user')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups('user')]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user')]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user')]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    #[Groups('user')]
    private ?array $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user')]
    private ?string $profile_picture_url = null;

    #[ORM\Column]
    #[Groups('user')]
    private array $roles = [];

    #[ORM\Column]
    #[Groups('user')]
    private bool $is_authenticated = false;

    #[ORM\Column(type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups('user')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups('user')]
    private ?\DateTimeImmutable $last_login = null;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'userId')]
    private Collection $notifications;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'userId')]
    private Collection $posts;

    /**
     * @var Collection<int, Reply>
     */
    #[ORM\OneToMany(targetEntity: Reply::class, mappedBy: 'userId')]
    private Collection $replies;

    /**
     * @var Collection<int, SentNotifications>
     */
    #[ORM\ManyToMany(targetEntity: SentNotifications::class, mappedBy: 'sent_to_user')]
    private Collection $sentNotifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->replies = new ArrayCollection();
        $this->sentNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhoneNumber(): ?array
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?array $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getProfilePictureUrl(): ?string
    {
        return $this->profile_picture_url;
    }

    public function setProfilePictureUrl(?string $profile_picture_url): static
    {
        $this->profile_picture_url = $profile_picture_url;

        return $this;
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

    public function isAuthenticated(): ?bool
    {
        return $this->is_authenticated;
    }

    public function setAuthenticated(bool $is_authenticated): static
    {
        $this->is_authenticated = $is_authenticated;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeImmutable
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeImmutable $last_login): static
    {
        $this->last_login = $last_login;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setUserId($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUserId() === $this) {
                $notification->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUserId($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUserId() === $this) {
                $post->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reply>
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(Reply $reply): static
    {
        if (!$this->replies->contains($reply)) {
            $this->replies->add($reply);
            $reply->setUserId($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): static
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getUserId() === $this) {
                $reply->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SentNotifications>
     */
    public function getSentNotifications(): Collection
    {
        return $this->sentNotifications;
    }

    public function addSentNotification(SentNotifications $sentNotification): static
    {
        if (!$this->sentNotifications->contains($sentNotification)) {
            $this->sentNotifications->add($sentNotification);
            $sentNotification->addSentToUser($this);
        }

        return $this;
    }

    public function removeSentNotification(SentNotifications $sentNotification): static
    {
        if ($this->sentNotifications->removeElement($sentNotification)) {
            $sentNotification->removeSentToUser($this);
        }

        return $this;
    }
}
