<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Email as Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ContactType;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Messages\ContactNotification;
use App\Service\CommentService;
use App\Service\EmailService;

class EmailController extends AbstractController
{
    #[Route('/email/show', name: 'app_email')]
    public function index(Request $request,EntityManagerInterface $em, EmailService $emailService): Response
    {
        $email = new Contact();
        $form = $this->createForm(ContactType::class,$email);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre message a été envoyer avec succès'
            ); 

            
            $r = $emailService->sendEmail($contact);

            return $this->redirectToRoute("app_email");
        }
        return $this->render('email/show.html.twig', [

            'controller_name' => 'EmailController',
            'title' => 'Contactez-nous',
            'form' => $form->createView(),
        ]);
    }
}
