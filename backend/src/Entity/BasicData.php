<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'basic_data')]
#[ApiResource]
class BasicData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'date')]
    private ?DateTime $birthDate = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\OneToOne(mappedBy: 'basicData', cascade: ['persist', 'remove'])]
    private ?ContactData $contactData = null;

    #[ORM\OneToMany(mappedBy: 'basicData', targetEntity: WorkExperience::class, cascade: ['persist', 'remove'])]
    private Collection $workExperiences;

    public function __construct()
    {
        $this->workExperiences = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getContactData(): ?ContactData
    {
        return $this->contactData;
    }

    public function setContactData(?ContactData $contactData): self
    {
        if ($contactData === null && $this->contactData !== null) {
            $this->contactData->setBasicData(null);
        }

        if ($contactData !== null && $contactData->getBasicData() !== $this) {
            $contactData->setBasicData($this);
        }

        $this->contactData = $contactData;
        return $this;
    }

    /**
     * @return Collection<int, WorkExperience>
     */
    public function getWorkExperiences(): Collection
    {
        return $this->workExperiences;
    }

    public function addWorkExperience(WorkExperience $workExperience): self
    {
        if (!$this->workExperiences->contains($workExperience)) {
            $this->workExperiences->add($workExperience);
            $workExperience->setBasicData($this);
        }

        return $this;
    }

    public function removeWorkExperience(WorkExperience $workExperience): self
    {
        if ($this->workExperiences->removeElement($workExperience)) {
            if ($workExperience->getBasicData() === $this) {
                $workExperience->setBasicData(null);
            }
        }

        return $this;
    }
}