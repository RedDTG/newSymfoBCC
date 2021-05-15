<?php

namespace App\Controller;

use App\Entity\Vendeur;
use App\Form\VendeurType;
use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendeur')]
class VendeurController extends AbstractController
{
    #[Route('/', name: 'vendeur_index', methods: ['GET'])]
    public function index(VendeurRepository $vendeurRepository): Response
    {
        return $this->render('vendeur/index.html.twig', [
            'vendeurs' => $vendeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'vendeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $vendeur = new Vendeur();
        $form = $this->createForm(VendeurType::class, $vendeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vendeur);
            $entityManager->flush();

            return $this->redirectToRoute('vendeur_index');
        }

        return $this->render('vendeur/new.html.twig', [
            'vendeur' => $vendeur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'vendeur_show', methods: ['GET'])]
    public function show(Vendeur $vendeur): Response
    {
        return $this->render('vendeur/show.html.twig', [
            'vendeur' => $vendeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'vendeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vendeur $vendeur): Response
    {
        $form = $this->createForm(VendeurType::class, $vendeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vendeur_index');
        }

        return $this->render('vendeur/edit.html.twig', [
            'vendeur' => $vendeur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'vendeur_delete', methods: ['POST'])]
    public function delete(Request $request, Vendeur $vendeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vendeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vendeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vendeur_index');
    }
}
