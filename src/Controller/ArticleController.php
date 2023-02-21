<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Media;
use App\Form\Type\CommentType;
use App\Service\CommentService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    private $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article, CommentService $commentService): Response
    {
        if(!$article){
            return $this->redirectToRoute('app_home');
        }

        $comment = new Comment($article);
        $commentForm = $this->createForm(CommentType::class, $comment);

        return $this->render('article/show.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article,
            'comments' => $commentService->getPaginatedComments($article),
            'commentForm' => $commentForm,
        ]);
    }
    
    // #[Route('/article/new', name: 'article_new')]
    // public function new(Request $request)
    // {
    //     $article = new Article();
    //     $form = $this->createForm(ArticleType::class, $article);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->entityManager;

    //         $imageFile = $form->get('featuredImageId')->getData();

    //         if ($imageFile) {
    //             $media = new Media();
    //             $media->setFilename($imageFile);
    //             $entityManager->persist($media);
    //             $entityManager->flush();

    //             $article->setFeaturedImageId($media);
    //         }

    //         $entityManager->persist($article);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_home');
    //     }

    //     return $this->render('admin/article/new.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

}
