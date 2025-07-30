<?php

namespace App\UI\Web\Controller;

use App\Domain\Patient\Entity\Patient;
use App\Domain\Therapist\Entity\Therapist;
use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $type = $request->request->get('type');

            $user = new User();
            $user->setEmail($email);
            $user->setPassword($hasher->hashPassword($user, $password));

            if ($type === 'patient') {
                $user->setRoles(['ROLE_PATIENT']);
                $patient = new Patient();
                $patient->setUser($user);
                $em->persist($patient);
                $user->setPatient($patient);
            } elseif ($type === 'therapist') {
                $user->setRoles(['ROLE_THERAPIST']);
                $therapist = new Therapist();
                $therapist->setUser($user);
                $em->persist($therapist);
                $user->setTherapist($therapist);
            } else {
                throw new \InvalidArgumentException('Tipo de usuario no válido');
            }

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('auth/register.html.twig');
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        return $this->render('auth/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony catches this route
    }
}
