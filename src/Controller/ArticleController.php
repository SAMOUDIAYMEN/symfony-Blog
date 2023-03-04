<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Media;
use App\Form\Type\CommentType;
use App\Service\CommentService;
use App\Repository\MediaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{

    private $entityManager;
    private $mediaRepository;

    public function __construct(ManagerRegistry $doctrine, MediaRepository $mediaRepository)
    {
        $this->entityManager = $doctrine->getManager();
        $this->mediaRepository = $mediaRepository;
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

}
