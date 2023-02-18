<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('Back/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
        ]);
    }
}
