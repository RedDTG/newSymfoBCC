<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Entity\Lot;
use App\Entity\Utilisateur;
use App\Entity\Vente;
use App\Form\EnchereType;
use App\Form\LotType;
use App\Repository\EnchereRepository;
use App\Repository\LotRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/lot')]
class LotController extends AbstractController
{
    #[Route('/', name: 'lot_index', methods: ['GET'])]
    public function index(LotRepository $lotRepository, EnchereRepository $encheres): Response
    {
        foreach ($lotRepository->findAll() as $i => $lot ) {
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

        return $this->render('lot/index.html.twig', [
            'lots' => $lotRepository->findAll(),
            'bestEncheres' => $bestEncheres
        ]);
    }

    #[Route('/new', name: 'lot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnchereRepository $encheres): Response
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

    #[Route('/{id}', name: 'lot_show', methods: ['GET', 'POST'])]
    public function show(Lot $lot, EnchereRepository $encheres, Request $request, UserInterface $userInterface, UtilisateurRepository $utilisateurRep): Response
    {
        $vente = $lot->getIdVente();
        $enchere = new Enchere();
        $enchere->setIdLot($lot);
        date_default_timezone_set('Europe/Paris');
        $date = new \DateTimeImmutable();
        $enchere->setHeure($date);
        $enchere->setDate($date);
        $enchere->setIdUtilisateur($utilisateurRep->findBy(["pseudo" => $userInterface->getUsername()])[0]);

        $bestEnchereForm = $encheres->findBy(
            ['idLot' => $lot->getId()],
            ['montant' =>'DESC'])
        [0] ?? $lot->getPrixDepart() -1;

        $form = $this->createForm(EnchereType::class, $enchere, array('bestEnchere' => $bestEnchereForm));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enchere);
            $entityManager->flush();

            return $this->redirectToRoute('vente_show', ['id' => $vente->getId()]);
        }

        return $this->render('lot/show.html.twig', [
            'enchere' => $enchere,
            'form' => $form->createView(),
            'lot' => $lot,
            'bestEnchere' => $encheres->findBy(
                ['idLot' => $lot->getId()],
                ['montant' =>'DESC'])
                [0] ?? 'Aucune',
            'vente' => $vente,
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

    #[Route('/{id}/encherir', name: 'lot_encherir', methods: ['GET', 'POST'])]
    public function encherir(Request $request, Lot $lot, EnchereRepository $encheres, UserInterface $userInterface, UtilisateurRepository $utilisateurRep ): Response
    {
        $enchere = new Enchere();
        $enchere->setIdLot($lot);
        date_default_timezone_set('Europe/Paris');
        $date = new \DateTimeImmutable();
        $enchere->setHeure($date);
        $enchere->setDate($date);
        $enchere->setIdUtilisateur($utilisateurRep->findBy(["pseudo" => $userInterface->getUsername()])[0]);

        $bestEnchere = $encheres->findBy(
            ['idLot' => $lot->getId()],
            ['montant' =>'DESC'])
        [0] ?? 0;

        $form = $this->createForm(EnchereType::class, $enchere, array('bestEnchere' => $bestEnchere));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($enchere);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lot_index');
        }

        return $this->render('enchere/new.html.twig', [
            'enchere' => $enchere,
            'bestEnchere' => $bestEnchere,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/produits', name: 'lot_produits', methods: ['GET'])]
    public function lotProduits(Lot $lot, ProduitRepository $produits): Response
    {
        return $this->render('lot/produits.html.twig', [
            'produits' => $produits->findBy(['idLot' => $lot]),
            '$lot' => $lot
        ]);
    }
}
