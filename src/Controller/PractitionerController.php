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
    #[Route('/practitioner/{id}', name: 'practitioner')]
    public function index(int $id, EntityManagerInterface $em): Response
    {
        $practitioner = $em->getRepository(User::class)->find($id);

        return $this->render('practitioner/index.html.twig', [
        'practitioner' => $practitioner,
        ]);
    }
}
