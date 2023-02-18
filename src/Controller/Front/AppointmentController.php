<?php

namespace App\Controller\Front;

use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
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

        if ($role == 'ROLE_PRATICIEN') {
            $appointments = $appointmentRepository->findBy(['patient_id' => $user->getId()]);
            return $this->render('Front/appointment/index.html.twig', [
                'appointments' => $appointments,
            ]);
        } elseif ($role == 'ROLE_PATIENT') {
            $appointments = $appointmentRepository->findBy(['praticien_id' => $user->getId()]);
            return $this->render('Front/appointment/index.html.twig', [
                'appointments' => $appointments,
            ]);
        } else {
            $appointments = $appointmentRepository->findAll();
            return $this->render('Front/appointment/index.html.twig', [
                'appointments' => $appointments,
            ]);
        }
    }

    #[Route('/{id}', name: 'app_front_appointment_show')]
    public function show($id, AppointmentRepository $appointmentRepository): Response
    {
        $appointment = $appointmentRepository->find($id);

        return $this->render('Front/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }
}
