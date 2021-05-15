<?php

namespace App\Controller;

use App\Entity\Acheteur;
use App\Form\AcheteurType;
use App\Repository\AcheteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/acheteur')]
class AcheteurController extends AbstractController
{
    #[Route('/', name: 'acheteur_index', methods: ['GET'])]
    public function index(AcheteurRepository $acheteurRepository): Response
    {
        return $this->render('acheteur/index.html.twig', [
            'acheteurs' => $acheteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'acheteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $acheteur = new Acheteur();
        $form = $this->createForm(AcheteurType::class, $acheteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($acheteur);
            $entityManager->flush();

            return $this->redirectToRoute('acheteur_index');
        }

        return $this->render('acheteur/new.html.twig', [
            'acheteur' => $acheteur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'acheteur_show', methods: ['GET'])]
    public function show(Acheteur $acheteur): Response
    {
        return $this->render('acheteur/show.html.twig', [
            'acheteur' => $acheteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'acheteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Acheteur $acheteur): Response
    {
        $form = $this->createForm(AcheteurType::class, $acheteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('acheteur_index');
        }

        return $this->render('acheteur/edit.html.twig', [
            'acheteur' => $acheteur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'acheteur_delete', methods: ['POST'])]
    public function delete(Request $request, Acheteur $acheteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acheteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($acheteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('acheteur_index');
    }
}
