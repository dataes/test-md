<?php

namespace App\Entity;

use App\Repository\NotificationBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationBlockRepository::class)
 */
class NotificationBlock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $user_validation;

    /**
     * @ORM\ManyToOne(targetEntity=notification::class, inversedBy="notificationBlocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $notification;

    /**
     * @ORM\OneToMany(targetEntity=NotificationBlockContent::class, mappedBy="notification_block", orphanRemoval=true)
     */
    private $notificationBlockContents;

    /**
     * NotificationBlock constructor.
     */
    public function __construct()
    {
        $this->notificationBlockContents = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool|null
     */
    public function getUserValidation(): ?bool
    {
        return $this->user_validation;
    }

    /**
     * @param bool $user_validation
     * @return $this
     */
    public function setUserValidation(bool $user_validation): self
    {
        $this->user_validation = $user_validation;

        return $this;
    }

    /**
     * @return notification|null
     */
    public function getNotification(): ?notification
    {
        return $this->notification;
    }

    /**
     * @param notification|null $notification
     * @return $this
     */
    public function setNotification(?notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return Collection|NotificationBlockContent[]
     */
    public function getNotificationBlockContents(): Collection
    {
        return $this->notificationBlockContents;
    }

    /**
     * @param NotificationBlockContent $notificationBlockContent
     * @return $this
     */
    public function addNotificationBlockContent(NotificationBlockContent $notificationBlockContent): self
    {
        if (!$this->notificationBlockContents->contains($notificationBlockContent)) {
            $this->notificationBlockContents[] = $notificationBlockContent;
            $notificationBlockContent->setNotificationBlock($this);
        }

        return $this;
    }

    /**
     * @param NotificationBlockContent $notificationBlockContent
     * @return $this
     */
    public function removeNotificationBlockContent(NotificationBlockContent $notificationBlockContent): self
    {
        if ($this->notificationBlockContents->removeElement($notificationBlockContent)) {
            // set the owning side to null (unless already changed)
            if ($notificationBlockContent->getNotificationBlock() === $this) {
                $notificationBlockContent->setNotificationBlock(null);
            }
        }

        return $this;
    }
}
