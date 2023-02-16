<?php

namespace App\Controller\Front;

use App\Form\UserAccountType;
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

    #[Route('/appointement', name: 'app_front_appointement')]
    public function indexAppointement(): Response
    {
        return $this->render('Front/user/appointement.html.twig', [

        ]);
    }

    #[Route('/account/edit', name: 'app_account_edit')]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);


        }

      // Call the edit form from the back controller
        return $this->render('account/edit.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}
