<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\Postulant;
use App\Entity\Recruteur;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Security("is_granted( 'ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Security("is_granted( 'ROLE_CANDIDAT')", statusCode: 404)]
    #[Route('/visible', name: 'app_annonce_index_visible', methods: ['GET'])]
    public function indexVisible(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findByVisible(1),
        ]);
    }

    #[Security("is_granted( 'ROLE_RECRUTEUR')", statusCode: 404)]
    #[Route('/recruteur/{recruteur}', name: 'app_annonce_index_recruteur', methods: ['GET'])]
    public function indexRecruteur(AnnonceRepository $annonceRepository, Recruteur $recruteur): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findByRecruteur($recruteur),
        ]);
    }

    #[Security("is_granted( 'ROLE_RECRUTEUR')", statusCode: 404)]
    #[Route('/new/{recruteur}', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository,Recruteur $recruteur): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setVisible(false);
            $annonce->setRecruteur($recruteur);
            $annonceRepository->add($annonce);
            return $this->redirectToRoute('app_annonce_index_recruteur', [
                'recruteur' => $recruteur->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Security("is_granted( 'ROLE_CONSULTANT') or is_granted('ROLE_RECRUTEUR')", statusCode: 404)]
    #[Route('/candidatsvalides/{recruteur}/{annonce}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce, EntityManagerInterface $entityManager): Response
    {/** @var Postulant $postulant */
        $postulant = $annonce->getPostulants();
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'postulant' => $postulant
        ]);
    }

    #[Security("is_granted( 'ROLE_CANDIDAT')", statusCode: 404)]
    #[Route('/{id}', name: 'app_annonce_show_candidat', methods: ['GET'])]
    public function showAnnonceToCandidat(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Security("is_granted( 'ROLE_RECRUTEUR')", statusCode: 404)]
    #[Route('/{recruteur}/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository, Recruteur $recruteur): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->add($annonce);
            return $this->redirectToRoute('app_annonce_index_recruteur', [
                'recruteur' => $recruteur->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Security("is_granted( 'ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Security("is_granted( 'ROLE_CONSULTANT')", statusCode: 404)]
    #[Route('/{id}/makeVisible/{visible}', name: 'app_annonce_makeVisible', methods: ['GET', 'POST'])]
    public function makeActive(Annonce $annonce, bool $visible, AnnonceRepository $annonceRepository): Response
    {
        $annonce->setVisible($visible);
        $annonceRepository->add($annonce);
        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Security("is_granted( 'ROLE_CANDIDAT')", statusCode: 404)]
    #[Route('/{id}/apply/{candidat}', name: 'app_annonce_apply', methods: ['GET', 'POST'])]
    public function apply(Annonce $annonce,Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        $postulant = new Postulant;
        $postulant->addAnnonce($annonce);
        $postulant->addCandidat($candidat);
        $postulant->setValide(false);
        $entityManager->persist($postulant);
        
        $entityManager->flush();
        return $this->redirectToRoute('app_annonce_index_visible', [], Response::HTTP_SEE_OTHER);
    }
}
