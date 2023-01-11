<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_front_index_index')]
    public function index(): Response
    {
        return $this->render('Front/index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }


    #[Route('/home', name: 'app_front_home')]
    public function index_unverified(): Response
    {
        return $this->render('Front/index/home.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
