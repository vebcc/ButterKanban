<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Form\ApiTokenType;
use App\Repository\ApiTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/token')]
class ApiTokenController extends AbstractController
{
    #[Route('/', name: 'app_api_token_index', methods: ['GET'])]
    public function index(ApiTokenRepository $apiTokenRepository): Response
    {
        return $this->render('api_token/index.html.twig', [
            'api_tokens' => $apiTokenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_api_token_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApiTokenRepository $apiTokenRepository): Response
    {
        $apiToken = new ApiToken();
        $form = $this->createForm(ApiTokenType::class, $apiToken);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiTokenRepository->add($apiToken);
            return $this->redirectToRoute('app_api_token_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('api_token/new.html.twig', [
            'api_token' => $apiToken,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_token_show', methods: ['GET'])]
    public function show(ApiToken $apiToken): Response
    {
        return $this->render('api_token/show.html.twig', [
            'api_token' => $apiToken,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_api_token_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApiToken $apiToken, ApiTokenRepository $apiTokenRepository): Response
    {
        $form = $this->createForm(ApiTokenType::class, $apiToken);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiTokenRepository->add($apiToken);
            return $this->redirectToRoute('app_api_token_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('api_token/edit.html.twig', [
            'api_token' => $apiToken,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_token_delete', methods: ['POST'])]
    public function delete(Request $request, ApiToken $apiToken, ApiTokenRepository $apiTokenRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apiToken->getId(), $request->request->get('_token'))) {
            $apiTokenRepository->remove($apiToken);
        }

        return $this->redirectToRoute('app_api_token_index', [], Response::HTTP_SEE_OTHER);
    }
}
