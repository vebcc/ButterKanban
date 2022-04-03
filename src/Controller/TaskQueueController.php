<?php

namespace App\Controller;

use App\Entity\TaskQueue;
use App\Form\TaskQueueType;
use App\Repository\TaskQueueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task/queue')]
class TaskQueueController extends AbstractController
{
    #[Route('/', name: 'app_task_queue_index', methods: ['GET'])]
    public function index(TaskQueueRepository $taskQueueRepository): Response
    {
        $taskQueue = new TaskQueue();
        $form = $this->createForm(TaskQueueType::class, $taskQueue, array(
            'action' => $this->generateUrl("app_task_queue_new")
        ));

        return $this->render('task_queue/index.html.twig', [
            'task_queues' => $taskQueueRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_task_queue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskQueueRepository $taskQueueRepository): Response
    {
        $taskQueue = new TaskQueue();
        $form = $this->createForm(TaskQueueType::class, $taskQueue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskQueueRepository->add($taskQueue);
            return $this->redirectToRoute('app_task_queue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_queue/new.html.twig', [
            'task_queue' => $taskQueue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_queue_show', methods: ['GET'])]
    public function show(TaskQueue $taskQueue): Response
    {
        return $this->render('task_queue/show.html.twig', [
            'task_queue' => $taskQueue,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_queue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskQueue $taskQueue, TaskQueueRepository $taskQueueRepository): Response
    {
        $form = $this->createForm(TaskQueueType::class, $taskQueue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskQueueRepository->add($taskQueue);
            return $this->redirectToRoute('app_task_queue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_queue/edit.html.twig', [
            'task_queues' => $taskQueueRepository->findAll(),
            'task_queue' => $taskQueue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_queue_delete', methods: ['POST'])]
    public function delete(Request $request, TaskQueue $taskQueue, TaskQueueRepository $taskQueueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskQueue->getId(), $request->request->get('_token'))) {
            $taskQueueRepository->remove($taskQueue);
        }

        return $this->redirectToRoute('app_task_queue_index', [], Response::HTTP_SEE_OTHER);
    }
}
