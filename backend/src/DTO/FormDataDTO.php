<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class FormDataDTO
{
  #[Assert\NotNull]
  #[Assert\Valid]
  private BasicDataDTO $basic;

  #[Assert\NotNull]
  #[Assert\Valid]
  private ContactDataDTO $contact;

  #[Assert\NotNull]
  #[Assert\Valid]
  #[Assert\Count(min: 1, minMessage: 'At least one work experience entry is required')]
  private array $workExperience = [];

  public function getBasic(): BasicDataDTO
  {
    return $this->basic;
  }

  public function setBasic(array $basic): self
  {
    $basicDTO = new BasicDataDTO();
    $basicDTO
      ->setFirstName($basic['firstName'])
      ->setLastName($basic['lastName'])
      ->setBirthDate($basic['birthDate']);

    $this->basic = $basicDTO;
    return $this;
  }

  public function getContact(): ContactDataDTO
  {
    return $this->contact;
  }

  public function setContact(array $contact): self
  {
    $contactDTO = new ContactDataDTO();
    $contactDTO
      ->setPhoneNumber($contact['phoneNumber'])
      ->setEmail($contact['email']);

    $this->contact = $contactDTO;
    return $this;
  }

  /**
   * @return WorkExperienceDTO[]
   */
  public function getWorkExperience(): array
  {
    return $this->workExperience;
  }

  public function setWorkExperience(array $experiences): self
  {
    $this->workExperience = [];
    foreach ($experiences as $exp) {
      $expDTO = new WorkExperienceDTO();
      $expDTO
        ->setCompany($exp['company'])
        ->setPosition($exp['position'])
        ->setDateFrom($exp['dateFrom'])
        ->setDateTo($exp['dateTo']);

      $this->workExperience[] = $expDTO;
    }
    return $this;
  }
}