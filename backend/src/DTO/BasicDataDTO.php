<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class BasicDataDTO
{
  #[Assert\NotBlank]
  #[Assert\Length(min: 2)]
  #[Assert\Regex(pattern: '/^[\p{L}\s\'-]+$/u', message: 'First name can only contain letters, spaces, hyphens and apostrophes')]
  private string $firstName;

  #[Assert\NotBlank]
  #[Assert\Length(min: 2)]
  #[Assert\Regex(pattern: '/^[\p{L}\s\'-]+$/u', message: 'Last name can only contain letters, spaces, hyphens and apostrophes')]
  private string $lastName;

  #[Assert\NotBlank]
  #[Assert\LessThan('today')]
  private \DateTime $birthDate;

  public function getFirstName(): string
  {
    return $this->firstName;
  }

  public function setFirstName(string $firstName): self
  {
    $this->firstName = $firstName;
    return $this;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function setLastName(string $lastName): self
  {
    $this->lastName = $lastName;
    return $this;
  }

  public function getBirthDate(): \DateTime
  {
    return $this->birthDate;
  }

  public function setBirthDate(string $birthDate): self
  {
    $this->birthDate = new \DateTime($birthDate);
    return $this;
  }
}