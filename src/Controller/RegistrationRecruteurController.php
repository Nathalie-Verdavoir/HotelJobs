<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Entity\User;
use App\Form\RegistrationRecruteurFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationRecruteurController extends AbstractController
{
    #[Route('/registerRecruteur', name: 'app_registerRecruteur')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationRecruteurFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $recruteur = new Recruteur();
            $recruteur->setUserid($user) ;
            $recruteur->setEntreprise($form->get('recruteurInfos')->getData()->getEntreprise()) ;
            $recruteur->setAdresse($form->get('recruteurInfos')->getData()->getAdresse()) ;
            $recruteur->setActif(false);
            
            $entityManager->persist($recruteur);
            
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            
            
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('registration/registerRecruteur.html.twig', [
            'registrationRecruteurForm' => $form->createView(),
        ]);
    }
}
