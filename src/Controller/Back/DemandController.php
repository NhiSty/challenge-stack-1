<?php

namespace App\Controller\Back;

use App\Entity\Demand;
use App\Entity\DocumentStorage;
use App\Entity\User;
use App\Form\DemandType;
use App\Repository\DemandRepository;
use App\Repository\DocumentStorageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/demand')]
class DemandController extends AbstractController
{
    #[Route('/', name: 'admin_app_demand_index', methods: ['GET'])]
    public function index(DemandRepository $demandRepository): Response
    {
        return $this->render('/Back/demand/index.html.twig', [
        'demands' => $demandRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'admin_app_demand_show', methods: ['GET'])]
    public function show(Demand $demand, DocumentStorageRepository $documentStorageRepository, DemandRepository $demandRepository): Response
    {
        $query = $demandRepository->findBy([
        'applicant' => $demand->getApplicant()->getId(),
        'state' => false,
        ]);

        $fileNamesOfApplicant = $query[0]->getFileNames();

        $demander_user_document_storage = $documentStorageRepository->findDemandedDocumentsOfUser($demand->getApplicant()->getId(), $fileNamesOfApplicant);
        return $this->render('/Back/demand/show.html.twig', [
        'demand' => $demand,
        'user_document_storage' => $demander_user_document_storage
        ]);
    }

    #[Route('/{id}', name: 'admin_app_demand_delete', methods: ['POST'])]
    public function delete(Request $request, Demand $demand, DemandRepository $demandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demand->getId(), $request->request->get('_token'))) {
            $demandRepository->remove($demand, true);
        }

        return $this->redirectToRoute('admin_app_demand_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/accept', name: 'admin_app_demand_accept', methods: ['POST'])]
    public function acceptDemand(Request $request, Demand $demand, DemandRepository $demandRepository, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('accept' . $demand->getId(), $request->request->get('_token'))) {
            $demand->setState(true);
            $demandRepository->save($demand, true);

            $praticien_to_change_role = $demand->getApplicant();
            $futur_verified_praticien = $userRepository->findBy(['id' => $praticien_to_change_role]);
            $futur_verified_praticien = $futur_verified_praticien[0];

            $futur_verified_praticien->setRoles(['ROLE_PRACTITIONER_VERIFIED']);
            $userRepository->save($futur_verified_praticien, true);
        }

        return $this->redirectToRoute('admin_app_demand_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/reject', name: 'admin_app_demand_reject', methods: ['POST'])]
    public function rejectDemand(Request $request, Demand $demand, DemandRepository $demandRepository): Response
    {
        if ($this->isCsrfTokenValid('reject' . $demand->getId(), $request->request->get('_token'))) {
            $demandRepository->remove($demand, true);
        }

        return $this->redirectToRoute('admin_app_demand_index', [], Response::HTTP_SEE_OTHER);
    }
}
