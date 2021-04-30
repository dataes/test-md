<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
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
    private $title;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $activation_date;

    /**
     * @ORM\OneToMany(targetEntity=NotificationBlock::class, mappedBy="notification", orphanRemoval=true)
     */
    private $notificationBlocks;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->notificationBlocks = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return DateImmutableType|null
     */
    public function getActivationDate(): ?DateImmutableType
    {
        return $this->activation_date;
    }

    /**
     * @param DateImmutableType|null $activation_date
     * @return $this
     */
    public function setActivationDate(?DateImmutableType $activation_date): self
    {
        $this->activation_date = $activation_date;

        return $this;
    }

    /**
     * @return Collection|NotificationBlock[]
     */
    public function getNotificationBlocks(): Collection
    {
        return $this->notificationBlocks;
    }

    /**
     * @param NotificationBlock $notificationBlock
     * @return $this
     */
    public function addNotificationBlock(NotificationBlock $notificationBlock): self
    {
        if (!$this->notificationBlocks->contains($notificationBlock)) {
            $this->notificationBlocks[] = $notificationBlock;
            $notificationBlock->setNotification($this);
        }

        return $this;
    }

    /**
     * @param NotificationBlock $notificationBlock
     * @return $this
     */
    public function removeNotificationBlock(NotificationBlock $notificationBlock): self
    {
        if ($this->notificationBlocks->removeElement($notificationBlock)) {
            // set the owning side to null (unless already changed)
            if ($notificationBlock->getNotification() === $this) {
                $notificationBlock->setNotification(null);
            }
        }

        return $this;
    }
}
