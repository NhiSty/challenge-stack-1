<?php

namespace App\Controller\Back;

use App\Entity\Drug;
use App\Form\DrugType;
use App\Repository\DrugRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/drug')]
class DrugController extends AbstractController
{
    #[Route('/', name: 'admin_app_drug_index', methods: ['GET'])]
    public function index(DrugRepository $drugRepository): Response
    {
        return $this->render('/Back/drug/index.html.twig', [
            'drugs' => $drugRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_app_drug_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DrugRepository $drugRepository): Response
    {
        $drug = new Drug();
        $form = $this->createForm(DrugType::class, $drug);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $drugRepository->save($drug, true);

            return $this->redirectToRoute('admin_app_drug_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/drug/new.html.twig', [
            'drug' => $drug,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_drug_show', methods: ['GET'])]
    public function show(Drug $drug): Response
    {
        return $this->render('/Back/drug/show.html.twig', [
            'drug' => $drug,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_app_drug_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Drug $drug, DrugRepository $drugRepository): Response
    {
        $form = $this->createForm(DrugType::class, $drug);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $drugRepository->save($drug, true);

            return $this->redirectToRoute('admin_app_drug_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/drug/edit.html.twig', [
            'drug' => $drug,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_drug_delete', methods: ['POST'])]
    public function delete(Request $request, Drug $drug, DrugRepository $drugRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$drug->getId(), $request->request->get('_token'))) {
            $drugRepository->remove($drug, true);
        }

        return $this->redirectToRoute('admin_app_drug_index', [], Response::HTTP_SEE_OTHER);
    }
}
