<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Repository\RecruteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recruteur')]
class RecruteurController extends AbstractController
{
    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/all', name: 'app_recruteur_index', methods: ['GET'])]
    public function index(RecruteurRepository $recruteurRepository): Response
    {
        return $this->render('recruteur/index.html.twig', [
            'recruteurs' => $recruteurRepository->findAll(),
        ]);
    }

    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/actif/{actif}', name: 'app_recruteur_index_valid', methods: ['GET'])]
    public function indexNoValid(RecruteurRepository $recruteurRepository,$actif): Response
    {
        return $this->render('recruteur/index.html.twig', [
            'recruteurs' => $recruteurRepository->findActif($actif),
        ]);
    }
/*
    #[Route('/new', name: 'app_recruteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RecruteurRepository $recruteurRepository): Response
    {
        $recruteur = new Recruteur();
        $form = $this->createForm(RecruteurType::class, $recruteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruteurRepository->add($recruteur);
            return $this->redirectToRoute('app_recruteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recruteur/new.html.twig', [
            'recruteur' => $recruteur,
            'form' => $form,
        ]);
    }
*/
    #[Security("is_granted( 'ROLE_CONSULTANT') or is_granted('ROLE_RECRUTEUR') or is_granted('ROLE_CANDIDAT')", statusCode: 404)]
    #[Route('/{id}', name: 'app_recruteur_show', methods: ['GET'])]
    public function show(Recruteur $recruteur): Response
    {
        return $this->render('recruteur/show.html.twig', [
            'recruteur' => $recruteur,
        ]);
    }

    /*
    #[Route('/{id}/edit', name: 'app_recruteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recruteur $recruteur, RecruteurRepository $recruteurRepository): Response
    {
        $form = $this->createForm(RecruteurType::class, $recruteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruteurRepository->add($recruteur);
            return $this->redirectToRoute('app_recruteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recruteur/edit.html.twig', [
            'recruteur' => $recruteur,
            'form' => $form,
        ]);
    }
*/
    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/{id}/makeActive/{actif}', name: 'app_recruteur_makeActive', methods: ['GET', 'POST'])]
    public function makeActive(Recruteur $recruteur, $actif, RecruteurRepository $recruteurRepository, EntityManagerInterface $entityManager): Response
    {   
        $user=$recruteur->getUserid();
        $user->setRoles(["ROLE_RECRUTEUR"]);
        $recruteur->setActif($actif);
        $recruteurRepository->add($recruteur);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_recruteur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/{id}', name: 'app_recruteur_delete', methods: ['POST'])]
    public function delete(Request $request, Recruteur $recruteur, RecruteurRepository $recruteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recruteur->getId(), $request->request->get('_token'))) {
            $recruteurRepository->remove($recruteur);
        }

        return $this->redirectToRoute('app_recruteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
