<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Form\AdministradorType;
use App\Repository\AdministradorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administrador")
 */
class AdministradorController extends AbstractController
{
    /**
     * @Route("/", name="administrador_index", methods={"GET"})
     */
    public function index(AdministradorRepository $administradorRepository): Response
    {
        return $this->render('administrador/index.html.twig', [
            'administradors' => $administradorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="administrador_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $administrador = new Administrador();
        $form = $this->createForm(AdministradorType::class, $administrador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($administrador);
            $entityManager->flush();

            return $this->redirectToRoute('administrador_index');
        }

        return $this->render('administrador/new.html.twig', [
            'administrador' => $administrador,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administrador_show", methods={"GET"})
     */
    public function show(Administrador $administrador): Response
    {
        return $this->render('administrador/show.html.twig', [
            'administrador' => $administrador,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="administrador_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Administrador $administrador): Response
    {
        $form = $this->createForm(AdministradorType::class, $administrador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administrador_index');
        }

        return $this->render('administrador/edit.html.twig', [
            'administrador' => $administrador,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administrador_delete", methods={"POST"})
     */
    public function delete(Request $request, Administrador $administrador): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrador->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($administrador);
            $entityManager->flush();
        }

        return $this->redirectToRoute('administrador_index');
    }
}
