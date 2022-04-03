<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType\TaskEditType;
use App\Form\TaskType\TaskType;
use App\Repository\TaskRepository;
use App\Services\Log\LogAdder;
use App\Services\Task\TaskProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, array(
            'action' => $this->generateUrl("app_task_new")
        ));
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskRepository $taskRepository, LogAdder $logAdder, Security $security): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, array(
            'action' => $this->generateUrl("app_task_new")
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->add($task);
            $logAdder->addNewTaskLog($task, $security->getUser());
            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, TaskRepository $taskRepository, LogAdder $logAdder, Security $security): Response
    {
        $form = $this->createForm(TaskEditType::class, $task);
        $form->handleRequest($request);

        $oldTask = $taskRepository->find($task->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->add($task);
            $logAdder->addEditTaskLog($task, $security->getUser(), $oldTask->getQueue());
            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/edit.html.twig', [
            'tasks' => $taskRepository->findAll(),
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $taskRepository->remove($task);
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
