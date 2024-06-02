<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController {
  public function __construct(
    private readonly SerializerInterface $serializer,
    private readonly EntityManagerInterface $entityManager,
    private readonly JWTTokenManagerInterface $JWTManager,
    private readonly UserPasswordHasherInterface $userPasswordHasher,
  ) {}

  #[Route('/api/user/me', name: 'me', methods: ['GET'])]
  public function me(Request $request) : JsonResponse {    
    $user = $this->getUser();

    if (!$user) {
      return new JsonResponse(['error' => 'Not logged in'], Response::HTTP_UNAUTHORIZED);
    }

    $json = $this->serializer->serialize($user, 'json', ['groups' => ['user']]);
    return new JsonResponse($json, json: true);
  }

  #[Route('/api/user/update_me', name: 'update_me', methods: ['POST'])]
  public function update_me(Request $request) : JsonResponse {
    $user = $this->getUser();

    if (!$user) {
      return new JsonResponse(['error' => 'Not logged in'], Response::HTTP_UNAUTHORIZED);
    }

    $data = json_decode($request->getContent(), true);

    if (isset($data['profilePictureURL'])) {
      if (filter_var($data['profilePictureURL'], FILTER_VALIDATE_URL)) {
        $user->setProfilePictureUrl($data['profilePictureURL']);
      }
    }

    if (isset($data['password']) && isset($data['confirmPassword'])) {
      if ($data['password'] === $data['confirmPassword']) {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']));
      }
    }

    $this->entityManager->persist($user);
    $this->entityManager->flush();

    try {
      $token = $this->JWTManager->create($user);
    } catch (\Exception $e) {
      throw new BadRequestException("Token generation failed: " . $e->getMessage());
    }

    return new JsonResponse(['success'=>true, 'token'=>$token], Response::HTTP_OK);
  }
}