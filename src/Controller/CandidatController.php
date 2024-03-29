<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidat')]
class CandidatController extends AbstractController
{
    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/', name: 'app_candidat_index', methods: ['GET'])]
    public function index(CandidatRepository $candidatRepository): Response
    {
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidatRepository->findAll(),
        ]);
    }

    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/actif/{actif}', name: 'app_candidat_index_valid', methods: ['GET'])]
    public function indexNoValid(CandidatRepository $candidatRepository,bool $actif): Response
    {
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidatRepository->findActif($actif),
        ]);
    }
/*
    #[Route('/new', name: 'app_candidat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CandidatRepository $candidatRepository): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidatRepository->add($candidat);
            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }
*/
    #[Security("is_granted('ROLE_CONSULTANT') or is_granted('ROLE_RECRUTEUR') or is_granted('ROLE_CANDIDAT')", statusCode: 404)]
    #[Route('/{id}', name: 'app_candidat_show', methods: ['GET'])]
    public function show(Candidat $candidat): Response
    {
        return $this->render('candidat/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }
/*
    #[Route('/{id}/edit', name: 'app_candidat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidat $candidat, CandidatRepository $candidatRepository): Response
    {
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidatRepository->add($candidat);
            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }
*/
    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/{id}/makeActive/{actif}', name: 'app_candidat_makeActive', methods: ['GET', 'POST'])]
    public function makeActive(Candidat $candidat,bool $actif, CandidatRepository $candidatRepository, EntityManagerInterface $entityManager): Response
    {   
        $user=$candidat->getUserid();
        $user->setRoles(["ROLE_CANDIDAT"]);
        $candidat->setActif($actif);
        $candidatRepository->add($candidat);
        $entityManager->persist($user);
        return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Security("is_granted('ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/{id}', name: 'app_candidat_delete', methods: ['POST'])]
    public function delete(Request $request, Candidat $candidat, CandidatRepository $candidatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidat->getId(), $request->request->get('_token'))) {
            $candidatRepository->remove($candidat);
        }

        return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
    }
}
