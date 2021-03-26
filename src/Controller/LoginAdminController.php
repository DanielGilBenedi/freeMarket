<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginAdminController extends AbstractController
{
    /**
     * @Route("/login/admin", name="login_admin")
     */
    public function index(): Response
    {
        return $this->render('login_admin/index.html.twig', [
            'controller_name' => 'LoginAdminController',
        ]);
    }
}
