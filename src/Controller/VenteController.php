<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\EnchereRepository;
use App\Repository\LotRepository;
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
    public function show(Vente $vente, LotRepository $lotRepository, EnchereRepository$encheres): Response
    {
        $bestEncheres = array();
        foreach ($lotRepository->findAll() as $i => $lot ) {
            if ($lot->getIdVente() === $vente) {
                $enchereByLot = $encheres->findBy(
                    ['idLot' => $lot->getId()],
                    ['montant' => 'DESC'], 1, 0);
                if ($enchereByLot) {
                    $bestEncheres[$i] = $enchereByLot[0];
                }
                else {
                    $enchereVide = new Enchere();
                    $enchereVide->setIdLot($lotRepository->findAll()[$i]);
                    $enchereVide->setMontant(-1);
                    $bestEncheres[$i] = $enchereVide;
                }
            }
        }
        $bestEncheres = array_values($bestEncheres);

        return $this->render('vente/show.html.twig', [
            'vente' => $vente,
            'lots' => $lotRepository->findBy(
                ['idVente' => $vente->getId()]
            ),
            'bestEncheres' => $bestEncheres
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

    #[Route('/{id}/lots', name: 'vente_lots', methods: ['GET'])]
    public function lots(Vente $vente, LotRepository $lotRepository, EnchereRepository $encheres): Response
    {
//        var_dump($encheres->findBy(
//            ['idLot' => 1],
//            ['montant' => 'DESC']));

        foreach ($lotRepository->findAll() as $i => $lot ) {
            if ($lot->getIdVente() === $vente) {
                $enchereByLot = $encheres->findBy(
                    ['idLot' => $lot->getId()],
                    ['montant' => 'DESC'], 1, 0);
                if ($enchereByLot) {
                    $bestEncheres[$i] = $enchereByLot[0];
                }
                else {
                    $enchereVide = new Enchere();
                    $enchereVide->setIdLot($lotRepository->findAll()[$i]);
                    $enchereVide->setMontant(-1);
                    $bestEncheres[$i] = $enchereVide;
                }
            }
        }

        $bestEncheres = array_values($bestEncheres);

        return $this->render('vente/lots.html.twig', [
            'vente' => $vente,
            'lots' => $lotRepository->findby(
                ['idVente' => $vente->getId()]
            ),
            'bestEncheres' => $bestEncheres
        ]);
    }
}
