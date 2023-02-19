<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PractitionerController extends AbstractController
{
    // Get the practitioner's profile
    #[Route('/practitioner-profile/{id}', name: 'practitioner-profile')]
    public function index(int $id, EntityManagerInterface $em): Response
    {
        $practitioner = $em->getRepository(User::class)->find($id);
        $agenda = $practitioner->getAgenda();

        if ($practitioner) {
            if (!$practitioner->isVerified()) {
                return $this->redirectToRoute('app_front_index');
            }
        } else {
            return $this->redirectToRoute('app_front_index');
        }

        return $this->render('practitioner/index.html.twig', [
            'practitioner' => $practitioner,
            'agenda' => $agenda,
        ]);
    }
}
