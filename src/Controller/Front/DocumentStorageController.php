<?php

namespace App\Controller\Front;

use App\Entity\DocumentStorage;
use App\Form\DocumentStorageType;
use App\Repository\DemandRepository;
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
        $this->denyAccessUnlessGranted('ROLE_PRACTITIONER_VERIFIED');
        $this->denyAccessUnlessGranted('ROLE_USER');
        $documentStorage = new DocumentStorage();
        $form = $this->createForm(DocumentStorageType::class, $documentStorage);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                $user = $this->getUser();
                $documentStorage->setUserId($user);
            }
            $documentStorageRepository->save($documentStorage, true);

            return $this->redirectToRoute('app_front_document_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/index', name: 'app_front_document_storage_index')]
    public function index(Request $request, DocumentStorageRepository $documentStorageRepository, DemandRepository $demandRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PRACTITIONER_VERIFIED');
        $this->denyAccessUnlessGranted('ROLE_USER');
        // find current users document storage
        $documentStorages = $documentStorageRepository->findBy(['user_id' => $this->getUser()->getId()]);
        if (in_array('ROLE_PRACTITIONER', $this->getUser()->getRoles())) {
            $user = $this->getUser();
            $demand = $demandRepository->findOneBy(['applicant' => $user->getId()]);
        }

        return $this->render('/Front/storage/index.html.twig', [
            'document_storages' => $documentStorages,
            'demand' => $demand ?? null,
        ]);
    }
}
