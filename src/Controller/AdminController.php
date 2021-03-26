<?php

namespace App\Controller;

use App\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/nuevoUsuario.html.twig');
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


    }
    /**
     * @Route("/crearUsuario", name="crearUsuario")
     */
    public function crearUsuario(Request $request, FormBuilderInterface $builder, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $builder
            ->add('Crear Cliente')
            ->add('empresa', TextType::class)
            ->add('telefono', TextType::class)
            ->add('nombre', TextType::class)
            ->add('cod_cliente', TextType::class)
            ->add('direccion', TextType::class)
            ->add('correo', EmailType::class)
            ->add('provincia', TextType::class)
            ->add('ciudad', TextType::class)
        ;
        // 1) build the form
        $user = new User();
        $cliente = new Cliente();
        $form = $this->createForm($builder, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

            $cliente->setEmpresa($request->get('empresa'));
            $cliente->setTelefono($request->get('telefono'));
            $cliente->setNombre($request->get('nombre'));
            $cliente->setCodCliente($request->get('cod_cliente'));
            $cliente->setDireccion($request->get('direccion'));
            $cliente->setCorreo($request->get('correo'));
            $cliente->setProvincia($request->get('provincia'));
            $cliente->setCiudad($request->get('ciudad'));
            $cliente->setContrasena($password);
            $cliente->setFecha(new \DateTime('@'.strtotime('now')));

            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );


    }

}
