<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Postulant;
use App\Form\PostulantType;
use App\Repository\PostulantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/postulant')]
class PostulantController extends AbstractController
{
    #[Route('/', name: 'app_postulant_index', methods: ['GET'])]
    public function index(PostulantRepository $postulantRepository): Response
    {
        return $this->render('postulant/index.html.twig', [
            'postulants' => $postulantRepository->findAll(),
        ]);
    }

    #[Security("is_granted('ROLE_CANDIDAT')", statusCode: 404)]
    #[Route('/candidat/{candidat}', name: 'app_postulant_candidat', methods: ['GET'])]
    public function indexCandidat(Candidat $candidat): Response
    {
        return $this->render('postulant/index.html.twig', [
            'postulants' => $candidat->getPostulants()->getValues(),
        ]);
    }

    #[Route('/new', name: 'app_postulant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostulantRepository $postulantRepository): Response
    {
        $postulant = new Postulant();
        $form = $this->createForm(PostulantType::class, $postulant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postulantRepository->add($postulant);
            return $this->redirectToRoute('app_postulant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postulant/new.html.twig', [
            'postulant' => $postulant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postulant_show', methods: ['GET'])]
    public function show(Postulant $postulant): Response
    {
        return $this->render('postulant/show.html.twig', [
            'postulant' => $postulant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_postulant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Postulant $postulant, PostulantRepository $postulantRepository): Response
    {
        $form = $this->createForm(PostulantType::class, $postulant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postulantRepository->add($postulant);
            return $this->redirectToRoute('app_postulant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postulant/edit.html.twig', [
            'postulant' => $postulant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postulant_delete', methods: ['POST'])]
    public function delete(Request $request, Postulant $postulant, PostulantRepository $postulantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postulant->getId(), $request->request->get('_token'))) {
            $postulantRepository->remove($postulant);
        }

        return $this->redirectToRoute('app_postulant_index', [], Response::HTTP_SEE_OTHER);
    }
}