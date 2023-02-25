<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{

    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout/{appointment}', name: 'checkout')]
    public function checkout(int $appointment): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        Stripe::setApiKey($this->getParameter("app.key"));


        $session = Session::create(['payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 25 * 100,
                    'product_data' => [
                        'name' => 'Consultation',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', ['appointment' => $appointment], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', ['appointment' => $appointment], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);


        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url/{appointment}', name: 'success_url', requirements: ['appointment' => '\d+'])]
    public function successUrl(int $appointment, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $appointment = $em->getRepository(Appointment::class)->find($appointment);

        if (!$appointment) {
            return $this->redirectToRoute('app_user_appointment_index');
        }
        if ($appointment->getPatientId() != $this->getUser()->getId()) {
            return $this->redirectToRoute('app_user_appointment_index');
        }

        $appointment->setPaid(true);
        $em->persist($appointment);
        $em->flush();



        return $this->render('payment/success.html.twig', []);
    }

    #[Route('/cancel-url/{appointment}', name: 'cancel_url')]
    public function cancelUrl(int $appointment,EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');


        $appointment = $em->getRepository(Appointment::class)->find($appointment);

        if (!$appointment) {
           return $this->redirectToRoute('app_user_appointment_index');
        }
        if ($appointment->getPatientId() != $this->getUser()->getId()) {
            return $this->redirectToRoute('app_user_appointment_index');
        }
        $em->remove($appointment);
        $em->flush();

        return $this->render('payment/cancel.html.twig', []);
    }

}
