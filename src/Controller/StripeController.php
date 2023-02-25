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
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);


        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url/{appointment}', name: 'success_url', requirements: ['appointment' => '\d+'])]
    public function successUrl(int $appointment, EntityManagerInterface $em): Response
    {

        $appointment = $em->getRepository(Appointment::class)->find($appointment);
        $appointment->setPaid(true);
        $em->persist($appointment);
        $em->flush();



        return $this->render('payment/success.html.twig', []);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(EntityManagerInterface $entityManager): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }

}
