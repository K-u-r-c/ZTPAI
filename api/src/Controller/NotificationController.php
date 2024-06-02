<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Notification;
use App\Entity\SentNotifications;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Session;

class NotificationController extends AbstractController {
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly SerializerInterface $serializer,
  ){}

  #[Route('/api/clock/get_notification', name: 'get_notification', methods: ['GET'])]
  public function getNotification() {
    $notifications = $this->entityManager->getRepository(Notification::class)->findAll();
    $notification = $notifications[array_rand($notifications)];

    $sentNotification = new SentNotifications();
    $sentNotification->addWhatNotification($notification);
    $sentNotification->addSentToUser($this->getUser());
    $sentNotification->setSentAt(new \DateTimeImmutable());
    
    $this->entityManager->persist($sentNotification);
    $this->entityManager->flush();

    $json = $this->serializer->serialize($notification, 'json', ['groups' => ['notification']]);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
  }

  #[Route('/api/clock/get_notifications', name: 'get_notifications', methods: ['GET'])]
  public function getNotifications(Request $request) {
    $session = $this->entityManager->getRepository(Session::class)->findOneBy(['user_id' => $this->getUser()], ['id' => 'DESC']);

    $sessionTime = $session->getStartTime();
    $sent_notifications = $this->entityManager->getRepository(SentNotifications::class)->findAll();
    
    $sent_notifications = array_filter($sent_notifications, function($notification) use ($sessionTime) {
      return $notification->getSentAt() > $sessionTime;
    });

    $notifications = array_map(function($sent_notification) {
      return $sent_notification->getWhatNotification();
    }, $sent_notifications);

    $json = $this->serializer->serialize($notifications, 'json', ['groups' => ['notification']]);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
  }
}