<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\User;
use App\Form\RegistrationCandidatFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer as Urlizer;

class RegistrationCandidatController extends AbstractController
{
    #[Route('/registerCandidat', name: 'app_registerCandidat')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationCandidatFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['cv']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/article_image';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename,
                    0777
                );
                $candidat = new Candidat();
                $candidat->setUserid($user) ;
                $candidat->setCvname($newFilename) ;
                $candidat->setActif(false);
                $user->setCandidat($candidat);
                $entityManager->persist($candidat);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('registration/registerCandidat.html.twig', [
            'registrationCandidatForm' => $form->createView(),
        ]);
    }
}
