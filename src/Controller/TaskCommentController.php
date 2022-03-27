<?php

namespace App\Controller;

use App\Entity\TaskComment;
use App\Form\TaskCommentType;
use App\Repository\TaskCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task/comment')]
class TaskCommentController extends AbstractController
{
    #[Route('/', name: 'app_task_comment_index', methods: ['GET'])]
    public function index(TaskCommentRepository $taskCommentRepository): Response
    {
        return $this->render('task_comment/index.html.twig', [
            'task_comments' => $taskCommentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_task_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskCommentRepository $taskCommentRepository): Response
    {
        $taskComment = new TaskComment();
        $form = $this->createForm(TaskCommentType::class, $taskComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskCommentRepository->add($taskComment);
            return $this->redirectToRoute('app_task_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_comment/new.html.twig', [
            'task_comment' => $taskComment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_comment_show', methods: ['GET'])]
    public function show(TaskComment $taskComment): Response
    {
        return $this->render('task_comment/show.html.twig', [
            'task_comment' => $taskComment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskComment $taskComment, TaskCommentRepository $taskCommentRepository): Response
    {
        $form = $this->createForm(TaskCommentType::class, $taskComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskCommentRepository->add($taskComment);
            return $this->redirectToRoute('app_task_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_comment/edit.html.twig', [
            'task_comment' => $taskComment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_comment_delete', methods: ['POST'])]
    public function delete(Request $request, TaskComment $taskComment, TaskCommentRepository $taskCommentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskComment->getId(), $request->request->get('_token'))) {
            $taskCommentRepository->remove($taskComment);
        }

        return $this->redirectToRoute('app_task_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
