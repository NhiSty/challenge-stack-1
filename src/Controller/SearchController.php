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
        $data = $specialityRepository->findOneBy(['name' => $query]);
        $usersBySpeciality = [];
        $usersByFirstName = [];
        $usersByLastName = [];

        if ($query && gettype($query) === "string") {
            if ($data) {
                $usersBySpeciality = $userRepository->findBy(['speciality' => $data->getId()]);
            }
            $usersByFirstName = $userRepository->findUsersByFistName($query);
            $usersByLastName = $userRepository->findUsersByLastName($query);
        }

        return $this->render('search/index.html.twig', [
            'search' => $query,
            'specialities' => $usersBySpeciality,
            'usersByFirstName' => $usersByFirstName,
            'usersByLastName' => $usersByLastName,
            'clinics' => $clinicRepository->findBy(['name' => $query]),
        ]);
    }
}
