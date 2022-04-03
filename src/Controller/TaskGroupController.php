<?php

namespace App\Controller;

use App\Entity\TaskGroup;
use App\Form\TaskGroupType;
use App\Repository\TaskGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task/group')]
class TaskGroupController extends AbstractController
{
    #[Route('/', name: 'app_task_group_index', methods: ['GET'])]
    public function index(TaskGroupRepository $taskGroupRepository): Response
    {
        $taskGroup = new TaskGroup();
        $form = $this->createForm(TaskGroupType::class, $taskGroup, array(
            'action' => $this->generateUrl("app_task_group_new")
        ));

        return $this->render('task_group/index.html.twig', [
            'task_groups' => $taskGroupRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_task_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskGroupRepository $taskGroupRepository): Response
    {
        $taskGroup = new TaskGroup();
        $form = $this->createForm(TaskGroupType::class, $taskGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskGroupRepository->add($taskGroup);
            return $this->redirectToRoute('app_task_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_group/new.html.twig', [
            'task_group' => $taskGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_group_show', methods: ['GET'])]
    public function show(TaskGroup $taskGroup): Response
    {
        return $this->render('task_group/show.html.twig', [
            'task_group' => $taskGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskGroup $taskGroup, TaskGroupRepository $taskGroupRepository): Response
    {
        $form = $this->createForm(TaskGroupType::class, $taskGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskGroupRepository->add($taskGroup);
            return $this->redirectToRoute('app_task_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_group/edit.html.twig', [
            'task_groups' => $taskGroupRepository->findAll(),
            'task_group' => $taskGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_group_delete', methods: ['POST'])]
    public function delete(Request $request, TaskGroup $taskGroup, TaskGroupRepository $taskGroupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskGroup->getId(), $request->request->get('_token'))) {
            $taskGroupRepository->remove($taskGroup);
        }

        return $this->redirectToRoute('app_task_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
