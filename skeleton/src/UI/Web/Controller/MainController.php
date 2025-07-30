<?php

namespace App\UI\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return new Response('<h1>Bienvenido a la plataforma</h1>');
    }

    #[Route('/dashboard/patient', name: 'patient_dashboard')]
    public function patientDashboard(): Response
    {
        return new Response('<h1>Panel del Paciente</h1>');
    }

    #[Route('/dashboard/therapist', name: 'therapist_dashboard')]
    public function therapistDashboard(): Response
    {
        return new Response('<h1>Panel del Terapeuta</h1>');
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function adminDashboard(): Response
    {
        return new Response('<h1>Panel de Administración</h1>');
    }
}
