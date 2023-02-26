<?php

namespace App\Controller\Back;

use App\Entity\DocumentStorage;
use App\Form\DocumentStorageType;
use App\Repository\DocumentStorageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/storage')]
class DocumentStorageController extends AbstractController
{
    #[Route('/', name: 'admin_app_document_storage_index', methods: ['GET'])]
    public function index(DocumentStorageRepository $documentStorageRepository): Response
    {
        return $this->render('/Back/document_storage/index.html.twig', [
            'document_storages' => $documentStorageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_app_document_storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentStorageRepository $documentStorageRepository): Response
    {
        $documentStorage = new DocumentStorage();
        $form = $this->createForm(DocumentStorageType::class, $documentStorage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                $documentStorage->setUserId($this->getUser());
            }

            $documentStorageRepository->save($documentStorage, true);

            return $this->redirectToRoute('admin_app_document_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/new.html.twig', [
            'document_storage' => $documentStorage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_document_storage_show', methods: ['GET'])]
    public function show(DocumentStorage $documentStorage): Response
    {
        return $this->render('/Back/document_storage/show.html.twig', [
            'document_storage' => $documentStorage,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_app_document_storage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DocumentStorage $documentStorage, DocumentStorageRepository $documentStorageRepository): Response
    {
        $form = $this->createForm(DocumentStorageType::class, $documentStorage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentStorageRepository->save($documentStorage, true);

            return $this->redirectToRoute('admin_app_document_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/edit.html.twig', [
            'document_storage' => $documentStorage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_document_storage_delete', methods: ['POST'])]
    public function delete(Request $request, DocumentStorage $documentStorage, DocumentStorageRepository $documentStorageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentStorage->getId(), $request->request->get('_token'))) {
            $documentStorageRepository->remove($documentStorage, true);
        }

        return $this->redirectToRoute('admin_app_document_storage_index', [], Response::HTTP_SEE_OTHER);
    }
}
