<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AccountController extends AbstractController {
  public function __construct(
    private readonly SerializerInterface $serializer,
  ) {}

  #[Route('/api/user/me', name: 'me', methods: ['GET'])]
  public function me(Request $request) : JsonResponse {    
    $user = $this->getUser();

    if (!$user) {
      return new JsonResponse(['error' => 'Not logged in'], Response::HTTP_UNAUTHORIZED);
    }

    $json = $this->serializer->serialize($user, 'json');
    return new JsonResponse($json, json: true);
  }
}