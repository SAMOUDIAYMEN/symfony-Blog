<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{username}', name: 'app_profile')]
    public function index(?User $user): Response
    {
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }
}
