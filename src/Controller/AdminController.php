<?php

namespace App\Controller;

use App\Entity\Demand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Get the number of 'false' of the 'state' field of the 'demand' table
        $demandFalse = $entityManager->getRepository(Demand::class)->count(['state' => false]);

        return $this->render('Back/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
            'demandFalse' => $demandFalse,
        ]);
    }
}
