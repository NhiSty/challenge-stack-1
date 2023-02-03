<?php

namespace App\Controller\Front;

use App\Entity\DocumentStorage;
use App\Form\DocumentStorageType;
use App\Repository\DocumentStorageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/storage')]
class DocumentStorageController extends AbstractController
{

    #[Route('/new', name: 'app_front_document_storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentStorageRepository $documentStorageRepository): Response
    {
        $documentStorage = new DocumentStorage();
        $form = $this->createForm(DocumentStorageType::class, $documentStorage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentStorageRepository->save($documentStorage, true);

            return $this->redirectToRoute('app_front_document_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/new.html.twig', [
            'document_storage' => $documentStorage,
            'form' => $form,
        ]);
    }
}
