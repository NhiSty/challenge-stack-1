<?php

namespace App\Controller\Front;

use App\Form\UserAccountType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        $this->denyAccessUnlessGranted('ROLE_USER_VERIFIED');
        return $this->render('Front/user/appointement.html.twig', [

        ]);
    }

    #[Route('/account/edit', name: 'app_account_edit')]
    public function edit(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserAccountType::class, $user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('plainPassword')->getData();

            if ($data !== null) {
                $user->setPassword($passwordHasher->hashPassword($user, $data));
            }

            $userRepository->save($user, true);
        }

      // Call the edit form from the back controller
        return $this->render('account/edit.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}
