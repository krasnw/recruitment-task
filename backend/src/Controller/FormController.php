<?php

namespace App\Controller;

use App\DTO\FormDataDTO;
use App\Entity\BasicData;
use App\Entity\ContactData;
use App\Entity\WorkExperience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FormController extends AbstractController
{
  #[Route('/api/form', name: 'app_form_submit', methods: ['POST'])]
  public function submit(
    Request $request,
    SerializerInterface $serializer,
    ValidatorInterface $validator,
    EntityManagerInterface $entityManager
  ): JsonResponse {
    try {
      // Deserialize JSON to FormDataDTO
      $formDataDTO = $serializer->deserialize(
        $request->getContent(),
        FormDataDTO::class,
        'json'
      );

      // Validate DTO
      $errors = $validator->validate($formDataDTO);
      if (count($errors) > 0) {
        $errorMessages = [];
        foreach ($errors as $error) {
          $errorMessages[] = $error->getMessage();
        }
        return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
      }

      // Create and persist BasicData entity
      $basicData = new BasicData();
      $basicData
        ->setFirstName($formDataDTO->getBasic()->getFirstName())
        ->setLastName($formDataDTO->getBasic()->getLastName())
        ->setBirthDate($formDataDTO->getBasic()->getBirthDate());

      $entityManager->persist($basicData);

      // Create and persist ContactData entity
      $contactData = new ContactData();
      $contactData
        ->setBasicData($basicData)
        ->setPhone($formDataDTO->getContact()->getPhoneNumber())
        ->setEmail($formDataDTO->getContact()->getEmail());

      $entityManager->persist($contactData);

      // Create and persist WorkExperience entities
      foreach ($formDataDTO->getWorkExperience() as $workExpDto) {
        $workExperience = new WorkExperience();
        $workExperience
          ->setBasicData($basicData)
          ->setCompanyName($workExpDto->getCompany())
          ->setPosition($workExpDto->getPosition())
          ->setDateFrom($workExpDto->getDateFrom())
          ->setDateTo($workExpDto->getDateTo());

        $entityManager->persist($workExperience);
      }

      // Save all entities
      $entityManager->flush();

      // Return success response with saved data and redirect URL
      return new JsonResponse(
        [
          'message' => 'Data saved successfully',
          'id' => $basicData->getId(),
          'redirect' => "/user/{$basicData->getId()}"
        ],
        Response::HTTP_CREATED
      );

    } catch (\Exception $e) {
      return $this->json([
        'error' => 'An error occurred while processing the request',
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route('/api/users', name: 'app_users_list', methods: ['GET'])]
  public function getUsersList(EntityManagerInterface $entityManager): JsonResponse
  {
    try {
      $basicDataRepository = $entityManager->getRepository(BasicData::class);
      $users = $basicDataRepository->findAll();

      $usersList = array_map(function($user) {
        return [
          'id' => $user->getId(),
          'firstName' => $user->getFirstName(),
          'lastName' => $user->getLastName(),
          'birthDate' => $user->getBirthDate()->format('Y-m-d')
        ];
      }, $users);

      return $this->json($usersList, Response::HTTP_OK);
    } catch (\Exception $e) {
      return $this->json([
        'error' => 'An error occurred while fetching users list',
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route('/api/users/{id}', name: 'app_user_details', methods: ['GET'])]
  public function getUserDetails(int $id, EntityManagerInterface $entityManager): JsonResponse
  {
    try {
      $basicData = $entityManager->getRepository(BasicData::class)->find($id);
      
      if (!$basicData) {
        return $this->json([
          'error' => 'User not found'
        ], Response::HTTP_NOT_FOUND);
      }

      $contactData = $entityManager->getRepository(ContactData::class)->findOneBy(['basicData' => $basicData]);
      $workExperience = $entityManager->getRepository(WorkExperience::class)->findBy(['basicData' => $basicData]);

      $response = [
        'basic' => [
          'firstName' => $basicData->getFirstName(),
          'lastName' => $basicData->getLastName(),
          'birthDate' => $basicData->getBirthDate()->format('Y-m-d')
        ],
        'contact' => [
          'phoneNumber' => $contactData->getPhone(),
          'email' => $contactData->getEmail()
        ],
        'workExperience' => array_map(function($work) {
          return [
            'company' => $work->getCompanyName(),
            'position' => $work->getPosition(),
            'dateFrom' => $work->getDateFrom()->format('Y-m-d'),
            'dateTo' => $work->getDateTo()->format('Y-m-d')
          ];
        }, $workExperience)
      ];

      return $this->json($response, Response::HTTP_OK);
    } catch (\Exception $e) {
      return $this->json([
        'error' => 'An error occurred while fetching user details',
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}