<?php

namespace App\Controller\Front;

use App\Entity\Appointment;
use App\Form\Appointment1Type;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

#[Route('user/appointment')]
class AppointmentController extends AbstractController
{
    #[Route('/', name: 'app_user_appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        $user = $this->getUser();
        return $this->render('/Front/appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findBy(['patient_id' => $user->getId()]),
        ]);
    }

    #[Route('/new', name: 'app_user_appointment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppointmentRepository $appointmentRepository, UserRepository $userRepository): Response
    {
        $practitioner = $userRepository->findOneBy(['id' => $request->query->get('practitioner_id')]);
        $appointment_type = $request->query->get('appointment_type');
        $agenda = $practitioner->getAgenda();
        $existingAppointments = $practitioner->getAppointments();
        $availableAppointments = [];
        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $currentDatePlusOneMonth = new \DateTime('+1 month');
        $index = 0;
        dump($existingAppointments);
        for ($i = $currentDate; $i < $currentDatePlusOneMonth; $i->modify('+1 day')) {
            $slots = [];
            foreach ($existingAppointments as $existingAppointment) {
                if ($existingAppointment->getDate()->format('Y-m-d') == $i->format('Y-m-d')) {
                    $formattedSlot = date('H:i',strtotime($existingAppointment->getSlot()));
                    dump($formattedSlot);
                    $slots = [
                        ...$slots,
                        $formattedSlot,
                    ];
                }
                else {
                }
            }
            if (empty($slots)) {
                $validSlots = array_filter($agenda->getSlots(), function ($slot) use ($i) {
                    $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                    $isToday = $currentDate->format('Y-m-d') == $i->format('Y-m-d');
                    $isAfter = $currentDate->format('H:i') < $slot;
                    return $isToday ? $isAfter : true;
                });
                $availableAppointments[$index] = [
                    'date' => $i->format('Y-m-d'),
                    'slots' => [...$validSlots],
                ];
            }
            else {
                if (count($slots) < count($agenda->getSlots())) {
                    $availableSlots = [...array_diff($agenda->getSlots(), $slots)];
                    $validSlots = array_filter($availableSlots, function ($slot) use ($i) {
                        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                        $isToday = $currentDate->format('Y-m-d') == $i->format('Y-m-d');
                        $isAfter = $currentDate->format('H:i') < $slot;
                        return $isToday ? $isAfter : true;
                    });
                    dump($validSlots);
                    dump($availableSlots);
                    $availableAppointments[$index] = [
                        'date' => $i->format('Y-m-d'),
                        'slots' => [...$validSlots],
                    ];
                }
            }
            $slots[] = [];
            $index++;
        }
        dump($availableAppointments);
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointment->setPatientId($this->getUser()->getId());
            $appointment->addPractitionerId($practitioner);
            $appointmentRepository->save($appointment, true);

            return $this->redirectToRoute('app_user_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($appointment_type == 'injection') {
            return $this->renderForm('/Front/appointment/new-drug.html.twig', [
                'form' => $form,
                'availableAppointments' => $availableAppointments,
            ]);
        }
        else {
            return $this->renderForm('/Front/appointment/new.html.twig', [
                'form' => $form,
                'availableAppointments' => $availableAppointments,
            ]);
        }
    }

    #[Route('/{id}', name: 'app_user_appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('/Front/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment, AppointmentRepository $appointmentRepository): Response
    {
        $form = $this->createForm(Appointment1Type::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointmentRepository->save($appointment, true);

            return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Front/appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, AppointmentRepository $appointmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $appointmentRepository->remove($appointment, true);
        }

        return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }
}
