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
use App\Entity\Reply;

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

    $json = $this->serializer->serialize($posts, 'json', ['groups' => ['post', 'user']]);
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

    $json = $this->serializer->serialize($post, 'json', ['groups' => ['post', 'reply', 'user']]);
    return new JsonResponse($json, json: true);
  }


  #[Route('/api/forum/post/{id}/incrementViews', name: 'increment_views', methods: ['GET'])]
  public function incrementViews($id)
  {
      $post = $this->entityManager
        ->getRepository(Post::class)
        ->find($id);

      $post->incrementViews();
      $this->entityManager->persist($post);
      $this->entityManager->flush();

      return new JsonResponse(['message' => 'Views incremented']);
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

  #[Route('/api/forum/create_reply', name: 'create_reply', methods: ['POST'])]
  public function createReply(Request $request): JsonResponse {
      $data = json_decode($request->getContent(), true);

      $post = $this->entityManager
          ->getRepository(Post::class)
          ->find($data['postId']);

      if (!$post) {
          return new JsonResponse(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
      }

      $reply = new Reply();
      $reply->setPostId($post);
      $reply->setUserId($this->getUser());
      $reply->setContent($data['content']);
      $reply->setRepliedAt(new \DateTimeImmutable());

      $this->entityManager->persist($reply);
      $this->entityManager->flush();

      return new JsonResponse(['success' => true, 'id' => $reply->getId()], Response::HTTP_CREATED);
  }
}