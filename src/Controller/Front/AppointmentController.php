<?php

namespace App\Controller\Front;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appointment')]
class AppointmentController extends AbstractController
{
    #[Route('/', name: 'app_front_appointment')]
    public function index(Request $request, AppointmentRepository $appointmentRepository, UserRepository $userRepository): Response
    {
      // Get the user role
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        $id = $user->getId();

        // @todo : afficher les rendez-vous du praticien connecté
        if ($role == 'ROLE_PRATICIEN') {
            $appointments = $appointmentRepository->findBy(['patient_id' => $id]);
        } elseif ($role == 'ROLE_PATIENT') {
            $appointments = $appointmentRepository->findBy(['praticien_id' => $id]);
        } else {
            $appointments = $appointmentRepository->findAll();
        }
        return $this->render('Front/appointment/index.html.twig', [
          'appointments' => $appointments,
        ]);
    }

    #[Route('/{id}', name: 'app_front_appointment_show')]
    public function show($id, AppointmentRepository $appointmentRepository): Response
    {
        $appointment = $appointmentRepository->find($id);

        return $this->render('Front/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_front_appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_front_appointment', [], Response::HTTP_SEE_OTHER);
    }
}
