<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class SecurityController extends AbstractController {
  public function __construct(
    private readonly UserPasswordHasherInterface $userPasswordHasher,
    private readonly EntityManagerInterface $entityManager,
    private readonly JWTTokenManagerInterface $JWTManager,
  ){}

  #[Route('/login', name: 'login', methods: ['POST'])]
  public function login(Request $request) {
    $data = json_decode($request->getContent(), true);
    $email = $data['email'];
    $password = $data['password'];

    $user = $this->entityManager
      ->getRepository(User::class)
      ->findOneBy(["email" => $email]);

    if (!$user) {
      return new JsonResponse(['message' => 'User not found'], Response::HTTP_OK);
    }

    if (!$this->userPasswordHasher->isPasswordValid($user, $password)) {
      return new JsonResponse(['message' => 'Invalid password'], Response::HTTP_OK);
    }

    try {
      $token = $this->JWTManager->create($user);
    } catch (\Exception $e) {
      throw new BadRequestException("Token generation failed: " . $e->getMessage());
    }

    $user->setLastLogin(new \DateTimeImmutable());
    $this->entityManager->persist($user);
    $this->entityManager->flush();

    return new JsonResponse(['success'=>true, 'token'=>$token], Response::HTTP_OK);
  }

  #[Route('/register', name: 'register', methods: ['POST'])]
  public function register(Request $request) {
    $data = json_decode($request->getContent(), true);
    $email = $data['email'];
    $username = $data['username'];
    $password = $data['password'];
    $repeatPassword = $data['repeatPassword'];

    if ($password !== $repeatPassword) {
      throw new BadRequestException("Passwords do not match");
    }

    $find = $this->entityManager
      ->getRepository(User::class)
      ->findBy(["email" => $email]);

    if ($find) {
      throw new BadRequestException("User already exists");
    }

    $user = new User();
    $user->setEmail($email);
    $user->setUsername($username);
    $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

    $user->setProfilePictureUrl('/images/default_user_profile.png');

    $this->entityManager->persist($user);
    $this->entityManager->flush();

    if (!$user->getId()) {
      throw new \Exception('User was not saved correctly');
    }

    try {
      $token = $this->JWTManager->create($user);
    } catch (\Exception $e) {
      throw new BadRequestException("Token generation failed: " . $e->getMessage());
    }

    return new JsonResponse(['success'=>true, 'token'=>$token], Response::HTTP_CREATED);
  }

  #[Route('/logout', name: 'logout', methods: ['POST'])]
  public function logout(Request $request) {
    return new JsonResponse(['success'=>true], Response::HTTP_OK);
  }
}