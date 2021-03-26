<?php

namespace App\Controller;

use App\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/logearse", name="logearse")
     */
    public function logearse(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $correo = $request->get('correo');
        $pass = $request->get('pass');
        $cliente = new Cliente();
        $pass =
            $passwordEncoder->encodePassword(
                $cliente,
                $pass);



        $user = $this->getDoctrine()->getRepository('App:Cliente')->findOneBy(
            array('correo' => $correo)
        );
var_dump($user);
        if(!$passwordEncoder->isPasswordValid($cliente,$pass)) {

            throw $this->createNotFoundException(
                'No se ha encontrado el usuario con nick: '.$correo. ' o los datos estan mal introducidos'
            );
        }

        return $this->render('inicio/inicio-cliente.html.twig', array(
            'cliente' => $user
        ));
    }
}
