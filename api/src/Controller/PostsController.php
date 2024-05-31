<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Post;

class PostsController extends AbstractController {
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly SerializerInterface $serializer,
  ){}

  #[Route('/api/forum/posts', name: 'posts', methods: ['GET'])]
  public function getPosts() {
    $posts = $this->entityManager
      ->getRepository(Post::class)
      ->findAll();

    $json = $this->serializer->serialize($posts, 'json', ['groups' => ['post']]);
    return new JsonResponse($json, json: true);
  }
}