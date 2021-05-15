<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Entity\Lot;
use App\Form\EnchereType;
use App\Form\LotType;
use App\Repository\EnchereRepository;
use App\Repository\LotRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lot')]
class LotController extends AbstractController
{
    #[Route('/', name: 'lot_index', methods: ['GET'])]
    public function index(LotRepository $lotRepository): Response
    {
        return $this->render('lot/index.html.twig', [
            'lots' => $lotRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'lot_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $lot = new Lot();
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lot);
            $entityManager->flush();

            return $this->redirectToRoute('lot_index');
        }

        return $this->render('lot/new.html.twig', [
            'lot' => $lot,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'lot_show', methods: ['GET'])]
    public function show(Lot $lot, EnchereRepository $encheres): Response
    {

        return $this->render('lot/show.html.twig', [
            'lot' => $lot,
            'bestEnchere' => $encheres->findBy(
                ['idLot' => $lot->getId()],
                ['montant' =>'DESC'])
                [0]
        ]);
    }

    #[Route('/{id}/edit', name: 'lot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lot $lot): Response
    {
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lot_index');
        }

        return $this->render('lot/edit.html.twig', [
            'lot' => $lot,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'lot_delete', methods: ['POST'])]
    public function delete(Request $request, Lot $lot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lot_index');
    }

    #[Route('/{id}', name: 'lot_encherir', methods: ['GET', 'POST'])]
    public function encherir(Request $request, Lot $lot): Response
    {
        $enchere = new Enchere();
        $enchere->setIdLot($lot->getId());
        $form = $this->createForm(EnchereType::class, $enchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($enchere);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lot_index');
        }

        return $this->render('lot/edit.html.twig', [
            'lot' => $lot,
            'form' => $form->createView(),
        ]);
    }
}
