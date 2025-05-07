<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'work_experience')]
#[ApiResource]
class WorkExperience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'workExperiences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BasicData $basicData = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    #[ORM\Column(type: 'date')]
    private ?DateTime $dateFrom = null;

    #[ORM\Column(type: 'date')]
    private ?DateTime $dateTo = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasicData(): ?BasicData
    {
        return $this->basicData;
    }

    public function setBasicData(?BasicData $basicData): self
    {
        $this->basicData = $basicData;
        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getDateFrom(): ?DateTime
    {
        return $this->dateFrom;
    }

    public function setDateFrom(DateTime $dateFrom): self
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function getDateTo(): ?DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(DateTime $dateTo): self
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}