<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class WorkExperienceDTO
{
  #[Assert\NotBlank]
  #[Assert\Length(min: 2)]
  private string $company;

  #[Assert\NotBlank]
  #[Assert\Length(min: 2)]
  private string $position;

  #[Assert\NotBlank]
  private \DateTime $dateFrom;

  #[Assert\NotBlank]
  private \DateTime $dateTo;

  public function getCompany(): string
  {
    return $this->company;
  }

  public function setCompany(string $company): self
  {
    $this->company = $company;
    return $this;
  }

  public function getPosition(): string
  {
    return $this->position;
  }

  public function setPosition(string $position): self
  {
    $this->position = $position;
    return $this;
  }

  public function getDateFrom(): \DateTime
  {
    return $this->dateFrom;
  }

  public function setDateFrom(string $dateFrom): self
  {
    $this->dateFrom = new \DateTime($dateFrom);
    return $this;
  }

  public function getDateTo(): \DateTime
  {
    return $this->dateTo;
  }

  public function setDateTo(string $dateTo): self
  {
    $this->dateTo = new \DateTime($dateTo);
    return $this;
  }

  #[Assert\Callback]
  public function validateDates(ExecutionContextInterface $context): void
  {
    if ($this->dateFrom > $this->dateTo) {
      $context->buildViolation('Start date must be before end date')
        ->atPath('dateFrom')
        ->addViolation();
    }
  }
}