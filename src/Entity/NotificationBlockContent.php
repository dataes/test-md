<?php

namespace App\Entity;

use App\Repository\NotificationBlockContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationBlockContentRepository::class)
 */
class NotificationBlockContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=NotificationBlock::class, inversedBy="notificationBlockContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $notification_block;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class, mappedBy="language_id")
     */
    private $languages;

    /**
     * NotificationBlockContent constructor.
     */
    public function __construct()
    {
        $this->languages = new ArrayCollection();
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
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return NotificationBlock|null
     */
    public function getNotificationBlock(): ?NotificationBlock
    {
        return $this->notification_block;
    }

    /**
     * @param NotificationBlock|null $notification_block
     * @return $this
     */
    public function setNotificationBlock(?NotificationBlock $notification_block): self
    {
        $this->notification_block = $notification_block;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    /**
     * @param Language $language
     * @return $this
     */
    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
            $language->addLanguageId($this);
        }

        return $this;
    }

    /**
     * @param Language $language
     * @return $this
     */
    public function removeLanguage(Language $language): self
    {
        if ($this->languages->removeElement($language)) {
            $language->removeLanguageId($this);
        }

        return $this;
    }
}
