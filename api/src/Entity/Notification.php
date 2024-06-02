<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('notification')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('notification')]
    private ?string $message = null;

    /**
     * @var Collection<int, SentNotifications>
     */
    #[ORM\ManyToMany(targetEntity: SentNotifications::class, mappedBy: 'what_notification')]
    private Collection $sentNotifications;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function __construct()
    {
        $this->sentNotifications = new ArrayCollection();
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
            $sentNotification->addWhatNotification($this);
        }

        return $this;
    }

    public function removeSentNotification(SentNotifications $sentNotification): static
    {
        if ($this->sentNotifications->removeElement($sentNotification)) {
            $sentNotification->removeWhatNotification($this);
        }

        return $this;
    }
}
