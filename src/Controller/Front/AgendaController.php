<?php

namespace App\Controller\Front;

use App\Entity\Agenda;
use App\Entity\User;
use App\Form\AgendaType;
use App\Repository\AgendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/practitioner/agenda')]
class AgendaController extends AbstractController
{
    #[Route('/', name: 'app_agenda_index', methods: ['GET'])]
    public function index(AgendaRepository $agendaRepository): Response
    {
        return $this->render('/Front/agenda/index.html.twig', [
            'agendas' => $agendaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agenda_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgendaRepository $agendaRepository): Response
    {
        $agenda = new Agenda();
        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agenda->setOwner($this->getUser());
            $agendaRepository->save($agenda, true);

            return $this->redirectToRoute('app_agenda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Front/agenda/new.html.twig', [
            'agenda' => $agenda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agenda_show', methods: ['GET'])]
    public function show(Agenda $agenda): Response
    {
        return $this->render('/Front/agenda/show.html.twig', [
            'agenda' => $agenda,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agenda_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agenda $agenda, AgendaRepository $agendaRepository): Response
    {
        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agendaRepository->save($agenda, true);

            return $this->redirectToRoute('app_agenda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Front/agenda/edit.html.twig', [
            'agenda' => $agenda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agenda_delete', methods: ['POST'])]
    public function delete(Request $request, Agenda $agenda, AgendaRepository $agendaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $agenda->getId(), $request->request->get('_token'))) {
            $agendaRepository->remove($agenda, true);
        }

        return $this->redirectToRoute('app_agenda_index', [], Response::HTTP_SEE_OTHER);
    }
}
