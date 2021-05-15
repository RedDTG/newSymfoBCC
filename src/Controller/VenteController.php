<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vente')]
class VenteController extends AbstractController
{
    #[Route('/', name: 'vente_index', methods: ['GET'])]
    public function index(VenteRepository $venteRepository): Response
    {
        return $this->render('vente/index.html.twig', [
            'ventes' => $venteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'vente_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/new.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'vente_show', methods: ['GET'])]
    public function show(Vente $vente): Response
    {
        return $this->render('vente/show.html.twig', [
            'vente' => $vente,
        ]);
    }

    #[Route('/{id}/edit', name: 'vente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vente $vente): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/edit.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'vente_delete', methods: ['POST'])]
    public function delete(Request $request, Vente $vente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_index');
    }

    #[Route('/', name: 'vente_lots', methods: ['GET'])]
    public function lots(VenteRepository $venteRepository): Response
    {
        return $this->render('vente/lots.html.twig', [
            'ventes' => $venteRepository->findAll(),
        ]);
    }
}
