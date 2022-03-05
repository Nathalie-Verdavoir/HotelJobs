<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Postulant;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    #[Route('/email/{annonce}/{postulant}', name: 'app_mail', methods: ['GET','POST'])]
    public function sendEmail(MailerInterface $mailer,Annonce $annonce,Postulant $postulant): Response
    {dump("https://hoteljobs.herokuapp.com/uploads/article_image/".$postulant->getCandidat()[0]->getCvname());
        $email = (new Email())
            ->from('brad@sandbox97fca9b4222d469192b1eb1f0ca0556f.mailgun.org')
            ->to('nat.aesh@orange.fr')
            //->to($annonce->getRecruteur()->getUserid()->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Nous avons trouvé un postulant pour votre offre : '.$postulant->getCandidat()[0]->getUserid()->getPrenom().' '.$postulant->getCandidat()[0]->getUserid()->getNom())
            ->html('<p>See Twig integration for better HTML integration!</p>')
            ->attachFromPath("https://hoteljobs.herokuapp.com/uploads/article_image/".$postulant->getCandidat()[0]->getCvname());

        $mailer->send($email);
dump('sent');
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'postulant' => $postulant,
            'recruteur' => $annonce->getRecruteur(),
            'id' => $annonce->getId(),
        ]);
    }
}