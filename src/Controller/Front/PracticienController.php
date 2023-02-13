<?php

namespace App\Controller\Front;

use App\Entity\DocumentStorage;
use App\Entity\User;
use App\Form\DocumentStorageType;
use App\Form\UserType;
use App\Repository\DocumentStorageRepository;
use App\Repository\NecessaryDocumentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/practicien')]
class PracticienController extends AbstractController
{
    #[Route('/home', name: 'app_front_practicien_home')]
    public function indexVerifiedPracticien(): Response
    {
        return $this->render('Front/practicien/home_practicien.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/new', name: 'app_front_practicien_document_storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentStorageRepository $documentStorageRepository, NecessaryDocumentRepository $necessaryDocumentRepository): Response
    {
        // get all necessary docs

        $necessaryDocs = $necessaryDocumentRepository->findAll();

        $documentStorage = new DocumentStorage();
        $form = $this->createForm(DocumentStorageType::class, null, [
            'necessaryDocs' => $necessaryDocs,
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            dump($form->getData());

            // loop over all uploaded docs
            for ($i = 0; $i < count($documentStorage->getDocFile()); $i++){

                $file = $documentStorage->getDocFile()[$i];

                $documentStorage->setUserId($user);
                $documentStorage->setDescription("Ceci est une description");
                $documentStorage->setDocFile($file);

                $documentStorageRepository->save($documentStorage, true);
            }

            return $this->redirectToRoute('app_front_practicien_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/new.html.twig', [
            'form' => $form,
            'necessaryDocs' => $necessaryDocs,
        ]);
    }

}
