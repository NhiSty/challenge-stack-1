<?php

namespace App\Controller\Back;

use App\Entity\Clinic;
use App\Form\ClinicType;
use App\Repository\ClinicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/clinic')]
class ClinicController extends AbstractController
{
    #[Route('/', name: 'admin_app_clinic_index', methods: ['GET'])]
    public function index(ClinicRepository $clinicRepository): Response
    {
        return $this->render('/Back/clinic/index.html.twig', [
            'clinics' => $clinicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_app_clinic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClinicRepository $clinicRepository): Response
    {
        $clinic = new Clinic();
        $form = $this->createForm(ClinicType::class, $clinic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clinicRepository->save($clinic, true);

            return $this->redirectToRoute('admin_app_clinic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/clinic/new.html.twig', [
            'clinic' => $clinic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_clinic_show', methods: ['GET'])]
    public function show(Clinic $clinic): Response
    {
        return $this->render('/Back/clinic/show.html.twig', [
            'clinic' => $clinic,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_app_clinic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clinic $clinic, ClinicRepository $clinicRepository): Response
    {
        $form = $this->createForm(ClinicType::class, $clinic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clinicRepository->save($clinic, true);

            return $this->redirectToRoute('admin_app_clinic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/clinic/edit.html.twig', [
            'clinic' => $clinic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_clinic_delete', methods: ['POST'])]
    public function delete(Request $request, Clinic $clinic, ClinicRepository $clinicRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clinic->getId(), $request->request->get('_token'))) {
            $clinicRepository->remove($clinic, true);
        }

        return $this->redirectToRoute('admin_app_clinic_index', [], Response::HTTP_SEE_OTHER);
    }
}
