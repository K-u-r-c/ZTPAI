<?php

namespace App\Entity;

use App\Repository\SentNotificationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SentNotificationsRepository::class)]
class SentNotifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('sent_notification')]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'sentNotifications')]
    private Collection $sent_to_user;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\ManyToMany(targetEntity: Notification::class, inversedBy: 'sentNotifications')]
    private Collection $what_notification;

    #[ORM\Column]
    #[Groups('sent_notification')]
    private ?\DateTimeImmutable $sent_at = null;

    public function __construct()
    {
        $this->sent_to_user = new ArrayCollection();
        $this->what_notification = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSentToUser(): Collection
    {
        return $this->sent_to_user;
    }

    public function addSentToUser(User $sentToUser): static
    {
        if (!$this->sent_to_user->contains($sentToUser)) {
            $this->sent_to_user->add($sentToUser);
        }

        return $this;
    }

    public function removeSentToUser(User $sentToUser): static
    {
        $this->sent_to_user->removeElement($sentToUser);

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getWhatNotification(): Collection
    {
        return $this->what_notification;
    }

    public function addWhatNotification(Notification $whatNotification): static
    {
        if (!$this->what_notification->contains($whatNotification)) {
            $this->what_notification->add($whatNotification);
        }

        return $this;
    }

    public function removeWhatNotification(Notification $whatNotification): static
    {
        $this->what_notification->removeElement($whatNotification);

        return $this;
    }

    public function getSentAt(): ?\DateTimeImmutable
    {
        return $this->sent_at;
    }

    public function setSentAt(\DateTimeImmutable $sent_at): static
    {
        $this->sent_at = $sent_at;

        return $this;
    }
}
