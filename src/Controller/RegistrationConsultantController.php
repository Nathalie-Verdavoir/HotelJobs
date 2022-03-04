<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationConsultantFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationConsultantController extends AbstractController
{
    #[Security("is_granted('ROLE_SUPER_ADMIN')", statusCode: 404)]
    #[Route('/registerConsultant', name: 'app_registerConsultant')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationConsultantFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_CONSULTANT"]);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('registration/registerConsultant.html.twig', [
            'registrationConsultantForm' => $form->createView(),
        ]);
    }
}
