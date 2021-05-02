<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $iso_code;

    /**
     * @ORM\ManyToMany(targetEntity=NotificationBlockContent::class, inversedBy="languages", cascade={"persist"})
     */
    private $language_id;

    /**
     * Language constructor.
     */
    public function __construct()
    {
        $this->language_id = new ArrayCollection();
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
    public function getIsoCode(): ?string
    {
        return $this->iso_code;
    }

    /**
     * @param string $iso_code
     * @return $this
     */
    public function setIsoCode(string $iso_code): self
    {
        $this->iso_code = $iso_code;

        return $this;
    }

    /**
     * @return Collection|NotificationBlockContent[]
     */
    public function getLanguageId(): Collection
    {
        return $this->language_id;
    }

    /**
     * @param NotificationBlockContent $languageId
     * @return $this
     */
    public function addLanguageId(NotificationBlockContent $languageId): self
    {
        if (!$this->language_id->contains($languageId)) {
            $this->language_id[] = $languageId;
        }

        return $this;
    }

    /**
     * @param NotificationBlockContent $languageId
     * @return $this
     */
    public function removeLanguageId(NotificationBlockContent $languageId): self
    {
        $this->language_id->removeElement($languageId);

        return $this;
    }

    public function __toString()
    {
        return $this->getIsoCode();
    }
}
