<?php

namespace App\Controller;

use App\Form\TaskQueueType\TaskQueueMultipleEntityType;
use App\Services\TaskQueue\TaskQueueProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, TaskQueueProvider $taskQueueProvider): Response
    {
        return $this->render('main/index.html.twig', [
            'queues' => $taskQueueProvider->getAllTaskQueues(),
        ]);
    }
}
