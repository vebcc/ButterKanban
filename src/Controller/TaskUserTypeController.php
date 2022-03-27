<?php

namespace App\Controller;

use App\Entity\TaskUserType;
use App\Form\TaskUserTypeType;
use App\Repository\TaskUserTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task/user/type')]
class TaskUserTypeController extends AbstractController
{
    #[Route('/', name: 'app_task_user_type_index', methods: ['GET'])]
    public function index(TaskUserTypeRepository $taskUserTypeRepository): Response
    {
        return $this->render('task_user_type/index.html.twig', [
            'task_user_types' => $taskUserTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_task_user_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskUserTypeRepository $taskUserTypeRepository): Response
    {
        $taskUserType = new TaskUserType();
        $form = $this->createForm(TaskUserTypeType::class, $taskUserType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskUserTypeRepository->add($taskUserType);
            return $this->redirectToRoute('app_task_user_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_user_type/new.html.twig', [
            'task_user_type' => $taskUserType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_user_type_show', methods: ['GET'])]
    public function show(TaskUserType $taskUserType): Response
    {
        return $this->render('task_user_type/show.html.twig', [
            'task_user_type' => $taskUserType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_user_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskUserType $taskUserType, TaskUserTypeRepository $taskUserTypeRepository): Response
    {
        $form = $this->createForm(TaskUserTypeType::class, $taskUserType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskUserTypeRepository->add($taskUserType);
            return $this->redirectToRoute('app_task_user_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task_user_type/edit.html.twig', [
            'task_user_type' => $taskUserType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_user_type_delete', methods: ['POST'])]
    public function delete(Request $request, TaskUserType $taskUserType, TaskUserTypeRepository $taskUserTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskUserType->getId(), $request->request->get('_token'))) {
            $taskUserTypeRepository->remove($taskUserType);
        }

        return $this->redirectToRoute('app_task_user_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
