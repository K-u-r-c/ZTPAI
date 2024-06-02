<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Session;

class SessionController extends AbstractController {
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly SerializerInterface $serializer,
  ){}

  #[Route('/api/clock/start_session', name: 'start_session', methods: ['POST'])]
  public function startSession() {
    $session = new Session();
    $session->setUserId($this->getUser());
    $session->setStartTime(new \DateTimeImmutable());
    
    $this->entityManager->persist($session);
    $this->entityManager->flush();

    $json = $this->serializer->serialize($session, 'json', ['groups' => ['session']]);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
  }

  #[Route('/api/clock/end_session', name: 'end_session', methods: ['POST'])]
  public function endSession() {
    $session = $this->entityManager->getRepository(Session::class)->findOneBy(['user_id' => $this->getUser(), 'endTime' => null]);

    if (!$session) {
      return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    $session->setEndTime(new \DateTimeImmutable());

    $totalTime = $session->getEndTime()->getTimestamp() - $session->getStartTime()->getTimestamp();
    $session->setTotalTime(new \DateInterval('PT' . $totalTime . 'S'));
    
    $this->entityManager->persist($session);
    $this->entityManager->flush();

    $json = $this->serializer->serialize($session, 'json', ['groups' => ['session']]);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
  }
  
  #[Route('/api/clock/get_last_session', name: 'get_last_session', methods: ['GET'])]
  public function getLastSession() {
    $session = $this->entityManager->getRepository(Session::class)->findOneBy(['user_id' => $this->getUser()], ['id' => 'DESC']);

    $end_time = $session->getEndTime();
    if ($end_time === null) {
      $session->setEndTime(new \DateTimeImmutable());

      $totalTime = $session->getEndTime()->getTimestamp() - $session->getStartTime()->getTimestamp();
      $session->setTotalTime(new \DateInterval('PT' . $totalTime . 'S'));
      
      $this->entityManager->persist($session);
      $this->entityManager->flush();
    }

    $json = $this->serializer->serialize($session, 'json', ['groups' => ['session']]);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
  }
}