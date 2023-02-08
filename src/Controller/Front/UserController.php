<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/home', name: 'app_front_home')]
    public function indexVerified(): Response
    {
        return $this->render('Front/user/home.html.twig', [

        ]);
    }

    #[Route('/home', name: 'app_front_home')]
    public function indexAppointement(): Response
    {
        return $this->render('Front/user/appointement.html.twig', [

        ]);
    }

}
