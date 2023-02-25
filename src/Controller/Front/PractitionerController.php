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

#[Route('/practitioner')]
class PractitionerController extends AbstractController
{
    #[Route('/appointments', name: 'app_front_practitioner_appointments')]
    public function indexVerifiedPracticien(): Response
    {
        $appointments = $this->getUser()->getAppointments();
        return $this->render('Front/appointment/index.html.twig', [
            'controller_name' => 'IndexController',
            'appointments' => $appointments,
        ]);
    }
    #[Route('/new', name: 'app_front_practicien_document_storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentStorageRepository $documentStorageRepository, NecessaryDocumentRepository $necessaryDocumentRepository, DemandRepository $demandRepository): Response
    {
        // get all necessary docs

        $necessaryDocs = $necessaryDocumentRepository->findAll();

        $documentStorage = new DocumentStorage();
        $form = $this->createForm(DocumentStorageType::class, $documentStorage, [
            'necessaryDocs' => $necessaryDocs,
        ]);
        $form->handleRequest($request);

        $demand = new Demand();

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            $files_demand = [];

            // loop over all uploaded docs
            for ($i = 0; $i < count($necessaryDocs); $i++){

                $documentStorage = new DocumentStorage();
                $file = $form->get('docFile' . $i)->getData();

                $documentStorage->setUserId($user);
                $documentStorage->setDescription("Ceci est une description");
                $documentStorage->setDocFile($file);

                $files_demand[] = $file->getClientOriginalName();

                $documentStorageRepository->save($documentStorage, true);

            }
            $demand->setFileNames($files_demand);
            $demand->setApplicant($user);
            $demand->setState(false);

            $demandRepository->save($demand, true);

            return $this->redirectToRoute('app_front_practicien_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/document_storage/new.html.twig', [
            'form' => $form,
            'necessaryDocs' => $necessaryDocs,
        ]);
    }

}
