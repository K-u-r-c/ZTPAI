<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController {

  #[Route('/register', name: 'register', methods: ['POST'])]
  public function register() {
    return new JsonResponse([
      'status' => 'OK',
      'message' => 'User registered successfully.'
    ]);
  }

  #[Route('/login', name: 'login', methods: ['POST'])]
  public function login() {
    return new JsonResponse([
      'status' => 'OK',
      'message' => 'User logged in successfully.'
    ]);
  }
}