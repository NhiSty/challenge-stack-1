<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ClinicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\SpecialityRepository;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET', 'POST'])]
    public function index(Request $request, UserRepository $userRepository, SpecialityRepository $specialityRepository, ClinicRepository $clinicRepository): Response
    {
        $query = $request->request->get('query');
        $data = $specialityRepository->findBySpeciality($query);
        $users = [];

        if ($query && gettype($query) === "string") {
            if ($data) {
                foreach ($data as $speciality) {
                    $users = [...$users, ...$userRepository->findBy(['speciality' => $speciality->getId()])];
                }
            }
            $users = [...$users, ...$userRepository->findUsersByFistName($query)];
            $users = [...$users, ...$userRepository->findUsersByLastName($query)];
        }

        $uniqueUsers = [];

        foreach ($users as $user) {
            if (in_array($user, $uniqueUsers)) {
                continue;
            } else {
                if ($user->isVerified() && in_array('ROLE_PRACTITIONER_VERIFIED', $user->getRoles())) {
                    $uniqueUsers[] = $user;
                }
            }
        }

        return $this->render('search/index.html.twig', [
            'search' => $query,
            'users' => $uniqueUsers,
            'clinics' => $clinicRepository->findByClinic($query),
        ]);
    }
}
