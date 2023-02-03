<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/practicien/')]
class PracticienController extends AbstractController
{
    #[Route('/home', name: 'app_front_practicien_home')]
    public function indexVerifiedPracticien(): Response
    {
        return $this->render('Front/practicien/home_practicien.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

}
