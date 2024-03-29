<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HealthCheckController extends AbstractController
{
    #[Route('/health-check', name: 'health_check', methods: ['GET'])]
    public function healthCheck(): Response
    {
        return $this->json([
            'status' => 'OK',
            'message' => 'API is running smoothly.',
        ]);
    }
}