<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDataDTO
{
  #[Assert\NotBlank]
  #[Assert\Regex(
    pattern: '/^\d{9}$/',
    message: 'Phone number must contain exactly 9 digits without any additional characters'
  )]
  private string $phoneNumber;

  #[Assert\NotBlank]
  #[Assert\Email]
  private string $email;

  public function getPhoneNumber(): string
  {
    return $this->phoneNumber;
  }

  public function setPhoneNumber(string $phoneNumber): self
  {
    $this->phoneNumber = $phoneNumber;
    return $this;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }
}