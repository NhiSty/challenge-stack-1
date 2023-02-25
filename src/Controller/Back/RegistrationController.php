<?php

namespace App\Controller\Back;

use App\Entity\Agenda;
use App\Entity\DocumentStorage;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationPracticienFormType;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private UserAuthenticatorInterface $userAuthenticator;
    private AppAuthenticator $authenticator;

    public function __construct(
        EmailVerifier $emailVerifier,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator,
    ) {
        $this->emailVerifier = $emailVerifier;
        $this->userAuthenticator = $userAuthenticator;
        $this->authenticator = $authenticator;
    }

    #[Route('/signup', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $agenda = new Agenda();
        $agenda->setOwner($user);
        $entityManager->persist($agenda);

        $form = $this->createForm(RegistrationFormType::class, $user);
        return $this->handle_registration($form, $request, $user, $userPasswordHasher, $entityManager, $agenda, 'Back/registration/register.html.twig',['ROLE_PATIENT']);
    }

    #[Route('/register', name: 'app_register_physician')]
    public function register_physician(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $agenda = new Agenda();
        $agenda->setOwner($user);
        $entityManager->persist($agenda);

        $form = $this->createForm(RegistrationPracticienFormType::class, $user);
        return $this->handle_registration($form, $request, $user, $userPasswordHasher, $entityManager, $agenda , 'Back/registration/register_practicien.html.twig',['ROLE_PRACTITIONER']);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets UserFixture::isVerified=true and persists
        $user = $this->getUser();
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('app_register');
        }

        $this->userAuthenticator->authenticateUser(
            $user,
            $this->authenticator,
            $request
        );

        if ($this->isGranted('ROLE_PRACTITIONER')) {
            return $this->redirectToRoute('app_front_practitioner_appointments');
        }elseif ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }
        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_front_home');
    }

    #[Route(path: '/sendConfirmation', name: 'app_send_verification_email', methods: ['GET'])]
    public function sendConfirmation(userInterface $user): RedirectResponse
    {
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('nhisty.dev@gmail.com', 'NhiSty'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('Back/registration/confirmation_email.html.twig')
        );

        return $this->redirectToRoute('app_front_index_unverified');
    }


    /**
     * @param FormInterface $form
     * @param Request $request
     * @param User $user
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param Agenda $agenda
     * @param string $view
     * @return RedirectResponse|Response
     */
    private function handle_registration(FormInterface $form, Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Agenda $agenda, string $view, array $roles): Response|RedirectResponse
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );


            $entityManager->persist($agenda);
            $user->setIsVerified(false);
            $user->setRoles($roles);
            $entityManager->persist($user);


            $entityManager->flush();

            // generate a signed url and email it to the user
            self::sendConfirmation($user);
            // do anything else you need here, like send an email

            //authenticate the user
            $this->userAuthenticator->authenticateUser(
                $user,
                $this->authenticator,
                $request
            );

            // add a flash message in english


            return $this->redirectToRoute('app_front_index_unverified');
        }

        return $this->render($view, [
            'registrationForm' => $form->createView(),
        ]);
    }
}
