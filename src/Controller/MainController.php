<?php

namespace App\Controller;

use App\Services\TaskGroup\TaskGroupProvider;
use App\Services\TaskQueue\TaskQueueProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(TaskQueueProvider $taskQueueProvider): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'tasks' => $taskQueueProvider->getAllTasksQueuesWithTasks(),
        ]);
    }
}
