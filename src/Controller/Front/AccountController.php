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
}
