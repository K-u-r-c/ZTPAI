<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;

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

  #[Route('/api/forum/post/{id}', name: 'post', methods: ['GET'])]
  public function getPost($id) {
    $post = $this->entityManager
      ->getRepository(Post::class)
      ->find($id);

    if (!$post) {
      return new JsonResponse(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
    }

    $json = $this->serializer->serialize($post, 'json', ['groups' => ['post']]);
    return new JsonResponse($json, json: true);
  }

  #[Route('/api/forum/create_post', name: 'create_post', methods: ['POST'])]
  public function createPost(Request $request) {
    $data = json_decode($request->getContent(), true);

    $post = new Post();
    $post->setTitle($data['title']);
    $post->setContent($data['content']);
    $post->setUserId($this->getUser());

    $category = $this->entityManager
      ->getRepository(Category::class)
      ->find(1);

    $post->setCategoryId($category);
    $post->setPostedAt(new \DateTimeImmutable());

    $this->entityManager->persist($post);
    $this->entityManager->flush();

    return new JsonResponse(['success' => true, 'id' => $post->getId()], Response::HTTP_CREATED);
  }
}