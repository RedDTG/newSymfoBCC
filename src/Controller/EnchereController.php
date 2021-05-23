<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Form\EnchereType;
use App\Repository\EnchereRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/enchere')]
class EnchereController extends AbstractController
{
    #[Route('/', name: 'enchere_index', methods: ['GET'])]
    public function index(EnchereRepository $enchereRepository, UserInterface $userInterface, UtilisateurRepository $users): Response
    {
        $encheres = $enchereRepository->findBy(['idUtilisateur' => $users->findBy(['pseudo' => $userInterface->getUsername()])], ['date'=> 'ASC', 'idLot' => 'ASC','montant' => 'DESC']);

        return $this->render('enchere/index.html.twig', [
            'encheres' => $encheres
        ]);
    }

    #[Route('/new', name: 'enchere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserInterface $userInterface): Response
    {

        $enchere = new Enchere();
        $form = $this->createForm(EnchereType::class, $enchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enchere);
            $entityManager->flush();

            return $this->redirectToRoute('enchere_index');
        }

        return $this->render('enchere/new.html.twig', [
            'enchere' => $enchere,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'enchere_show', methods: ['GET'])]
    public function show(Enchere $enchere): Response
    {
        return $this->render('enchere/show.html.twig', [
            'enchere' => $enchere,
        ]);
    }

    #[Route('/{id}/edit', name: 'enchere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enchere $enchere): Response
    {
        $form = $this->createForm(EnchereType::class, $enchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enchere_index');
        }

        return $this->render('enchere/edit.html.twig', [
            'enchere' => $enchere,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'enchere_delete', methods: ['POST'])]
    public function delete(Request $request, Enchere $enchere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enchere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enchere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('enchere_index');
    }
}
