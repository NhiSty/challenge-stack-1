<?php

namespace App\Controller\Front;

use App\Entity\Demand;
use App\Entity\DocumentStorage;
use App\Entity\User;
use App\Form\AppointmentType;
use App\Form\DocumentStorageType;
use App\Form\UserType;
use App\Repository\AppointmentRepository;
use App\Repository\DemandRepository;
use App\Repository\DocumentStorageRepository;
use App\Repository\NecessaryDocumentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\Translation\t;

#[Route('/practitioner')]
class PractitionerController extends AbstractController
{
    #[Route('/appointments', name: 'app_front_practitioner_appointments')]
    public function indexVerifiedPracticien(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PRACTITIONER_VERIFIED');

        $appointments = $this->getUser()->getAppointments();
        return $this->render('Front/appointment/index.html.twig', [
            'controller_name' => 'IndexController',
            'appointments' => $appointments,
        ]);
    }

    #[Route('/index', name: 'app_front_practicien_document_storage_index')]
    public function index(Request $request, DocumentStorageRepository $documentStorageRepository, DemandRepository $demandRepository): Response
    {
        // find current users document storage
        $documentStorages = $documentStorageRepository->findBy(['user_id' => $this->getUser()->getId()]);

        $alreadyDemanded = $demandRepository->findBy(['applicant' => $this->getUser()->getId()]);
         return $this->render('/Front/storage/index.html.twig', [
                'document_storages' => $documentStorages,
                'alreadyDemanded' => $alreadyDemanded,
         ]);
    }

    #[Route('/demand', name: 'app_front_practicien_new_demand', methods: ['GET', 'POST'])]
    public function demand(Request $request, DocumentStorageRepository $documentStorageRepository, NecessaryDocumentRepository $necessaryDocumentRepository, DemandRepository $demandRepository): Response
    {
        $isForDemand = true;
        // get all necessary docs
        $necessaryDocs = $necessaryDocumentRepository->findAll();

        $documentStorage = new DocumentStorage();
        $form = $this->createForm(DocumentStorageType::class, $documentStorage, [
            'necessaryDocs' => $necessaryDocs,
            'isForDemand' => $isForDemand,
        ]);
        $form->handleRequest($request);

        $demand = new Demand();

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $files_demand = [];

            // loop over all uploaded docs
            for ($i = 0; $i < count($necessaryDocs); $i++) {
                $documentStorage = new DocumentStorage();
                $file = $form->get('docFile' . $i)->getData();


                $documentStorage->setUserId($user);
                $documentStorage->setDescription("Ceci est une description");
                $documentStorage->setDocFile($file);

                $documentStorageRepository->save($documentStorage, true);

                $files_demand[] = $documentStorage->getName();
            }

            $demand->setFileNames($files_demand);
            $demand->setApplicant($user);
            $demand->setState(false);

            $demandRepository->save($demand, true);

            return $this->redirectToRoute('app_front_practicien_document_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/new.html.twig', [
            'form' => $form,
            'necessaryDocs' => $necessaryDocs,
            'isForDemand' => $isForDemand,
        ]);
    }

    #[Route('/new', name: 'app_front_practicien_document_storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentStorageRepository $documentStorageRepository, NecessaryDocumentRepository $necessaryDocumentRepository, DemandRepository $demandRepository): Response
    {
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
            'isForDemand' => false,
        ]);
    }

    #[Route('/sended_documents', name: 'app_front_practicien_sended_documents', methods: ['GET', 'POST'])]
    public function sendedDocuments(Request $request, DocumentStorageRepository $documentStorageRepository, NecessaryDocumentRepository $necessaryDocumentRepository, DemandRepository $demandRepository): Response
    {
        $demand = $demandRepository->findOneBy(['applicant' => $this->getUser()->getId()]);
        $files_demand = $demand->getFileNames();

        $demander_user_document_storage = $documentStorageRepository->findDemandedDocumentsOfUser($demand->getApplicant()->getId(), $files_demand);

        return $this->render('/Front/practitioner/sended_documents.html.twig', [
            'sended_docs' => $demander_user_document_storage,
        ]);
    }
}
