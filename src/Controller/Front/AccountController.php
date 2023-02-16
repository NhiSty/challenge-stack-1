<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
      // Redirect to login if not logged in
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

      // Get current user
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
          'user' => $user,
        ]);
    }

    #[Route('/account/edit', name: 'app_account_edit')]
    public function edit(): Response
    {

      $form = $this->createForm(UserType::class, $user);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $userRepository->save($user, true);

        return $this->redirectToRoute('admin_app_user_index', [], Response::HTTP_SEE_OTHER);
      }

        // Call the edit form from the back controller
        return $this->render('account/edit.html.twig', [

        ]);
    }
}
